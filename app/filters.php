<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			Session::put('login_error', true);
			return Redirect::intended('/');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Recipe Owner Route
|--------------------------------------------------------------------------
|
| This filter should only allow those who are the creator of the recipe
| to have access to the route.
|
*/

Route::filter('recipe_owner', function()
{
	$recipe = Route::input('recipe');
	if($recipe->author_id != Auth::id()){
		return Redirect::to('recipe/'.$recipe->slug);
	}
});


/*
|--------------------------------------------------------------------------
| Matches Logged In
|--------------------------------------------------------------------------
|
| This filter ensures that the user passed to the route is the same
| that is logged in.
|
*/

Route::filter('matches_logged_in', function()
{
	$user = Route::input('user');
	if($user->id != Auth::id()){
		App::abort(404);
	}
});


Entrust::routeNeedsRole( 'admin*', 'Admin', Redirect::to('/') );

View::composer('*', function($view)
{
	$top_categories = Category::all();
	foreach($top_categories as $category){
		$category->recipe = Recipe::find($category->related_recipe_id);
		if($category->recipe){
			$category->user = User::find($category->recipe->author_id);
		}
	}

	$sort = '';
	if(Input::has('sort')){
		$sort = Input::get('sort');
	}

	$default_bg_recipes = Recipe::take(3)->get();

	$view->with(array(
		'top_categories' => $top_categories,
		'sort' => $sort,
		'default_bg_recipes' => $default_bg_recipes
	));
});

View::composer(array('profile', 'cookbook', 'userRecipes', 'userReviews'), function($view)
{
	$user = $view->getData()['user'];

	$recipe_stats['total'] = Recipe::where('author_id', '=', $user->id)->count();
	$recipe_stats['subscribers'] = Recipe::where('author_id', '=', $user->id)->sum('subscriber_count');
	$recipe_stats['avg_rating'] = round(Recipe::where('author_id', '=', $user->id)->avg('overall_rating'), 2);
	$recipe_stats['reviews'] = Recipe::join('reviews', 'recipes.id', '=', 'reviews.recipe_id')->where('recipes.author_id', '=', $user->id)->count();

	$review_stats['total'] = Review::where('reviewer_id', '=', $user->id)->count();
	$review_stats['helpful'] = Review::where('reviewer_id', '=', $user->id)->sum('helpful') - Review::where('reviewer_id', '=', $user->id)->sum('non_helpful');


	if($user->subscribed_recipes){
		$total_cookbook = sizeof(explode(' ', trim($user->subscribed_recipes)));
	}
	else{
		$total_cookbook = 0;
	}

	$bg_recipes = Recipe::where('author_id', '=', $user->id)->take(20)->get();

	$view->with(array(
		'recipe_stats' => $recipe_stats,
		'review_stats' => $review_stats,
		'total_cookbook' => $total_cookbook,
		'bg_recipes' => $bg_recipes
	));
});