<?php

Route::bind('user', function($value)
{
    if($user = User::where('username', $value)->first()) {
        return $user;
    }

    App::abort(404);
});
Route::bind('recipe', function($value)
{
    if($recipe = Recipe::where('slug', $value)->first()){
        return $recipe;
    }
    elseif($recipe = Recipe::where('name', $value)->first()){
        return $recipe;
    }
    App::abort(404);
});

Route::get('/', array('uses' => 'HomeController@displayIndex'));
Route::get('/loadRecipes/{skip_amount}', array('uses' => 'HomeController@loadRecipes'));
Route::get('about', array('uses' => 'HomeController@about'));
Route::get('terms', array('uses' => 'HomeController@terms'));

Route::get('contact', array('uses' => 'HomeController@contact'));
Route::post('contact', array('before' => 'csrf', 'uses' => 'HomeController@sendContact'));

// Search routes
Route::group(array('prefix' => 'search'), function(){
    Route::get('{i?}/user', array('uses' => 'SearchController@displayUserSearchResults'));
    Route::get('{i?}', array('uses' => 'SearchController@displaySearchResults'));

    Route::post('{i?}', array('uses' => 'SearchController@redirectSearchResults'));
    Route::post('{i}/user', array('uses' => 'SearchController@redirectUserSearchResults'));
});

// Recipe routes
Route::group(array('prefix' => 'recipe', 'before' => 'auth'), function(){
    Route::get('add/{recipe}', array('uses' => 'RecipeController@addRecipeToUser'));
    Route::get('remove/{recipe}', array('uses' => 'RecipeController@removeRecipeFromUser'));
    Route::get('new', array('uses' => 'RecipeController@displayEdit'));
    Route::get('{recipe}/edit', array('before' => 'recipe_owner', 'uses' => 'RecipeController@displayEdit'));
    Route::get('{recipe}/reviewer/{username}/{helpful}', array('uses' => 'HelpfulReviewController@add'));

    Route::post('{recipe}/addReview', array('uses' => 'ReviewController@add'));
    Route::post('new', array('before' => 'csrf', 'uses' => 'RecipeController@saveRecipe'));
    Route::post('{recipe}/edit', array('before' => 'csrf|recipe_owner', 'uses' => 'RecipeController@saveRecipe'));
});
Route::get('recipe/loadRecipes/{search_term}/{skip_amount?}', array('uses' => 'RecipeController@loadRecipes'));
Route::get('recipe/{recipe}/getReviews/{skip_amount}/{amount?}', array('uses' => 'ReviewController@loadReviews'));
Route::get('recipe/{recipe}', array('uses' => 'RecipeController@show'));

// Category routes
Route::group(array('prefix' => 'category'), function(){
    Route::get('/all', array('uses' => 'CategoryController@showAll'));
    Route::get('/all/loadRecipes/{skip_amount}', array('uses' => 'CategoryController@loadAllRecipes'));

    Route::get('/{category}', array('uses' => 'CategoryController@show'));
    Route::get('/{category}/loadRecipes/{skip_amount}', array('uses' => 'CategoryController@loadRecipes'));
});

// Profile routes
Route::group(array('prefix' => 'profile'), function(){
    Route::get('/{user}', array('uses' => 'ProfileController@show'));
    Route::get('/{user}/recipes', array('uses' => 'ProfileController@showRecipes'));
    Route::get('/{user}/reviews', array('uses' => 'ProfileController@showReviews'));
    Route::get('/{user}/loadRecipes/{skip_amount}', array('uses' => 'ProfileController@loadRecipes'));
    Route::get('/{user}/loadReviews/{skip_amount}', array('uses' => 'ProfileController@loadReviews'));
    Route::get('/{user}/edit', array('before' => 'auth|matches_logged_in', 'uses' => 'ProfileController@showEdit'));
    Route::post('/{user}/deleteImage', array('before' => 'auth|matches_logged_in', 'uses' => 'ProfileController@deleteImage'));

    Route::post('/{user}/edit', array('before' => 'auth|csrf|matches_logged_in', 'uses' => 'ProfileController@doEdit'));
});

// Cookbook routes
Route::group(array('prefix' => 'cookbook'), function(){
    Route::get('/addRecipe/{recipe}', array('before' => 'auth', 'uses' => 'CookbookController@addRecipeToUser'));
    Route::get('/removeRecipe/{recipe}', array('before' => 'auth', 'uses' => 'CookbookController@removeRecipeFromUser'));
    Route::get('/{user}', array('uses' => 'CookbookController@displayCookbook'));
    Route::get('/{user}/loadRecipes/{skip_amount}', array('uses' => 'CookbookController@loadRecipes'));
});

// User routes
Route::group(array('prefix' => 'users'), function(){
    Route::get('settings', array('before' => 'auth', 'uses' => 'UsersController@settings'));
    Route::post('settings', array('before' => 'auth|csrf', 'uses' => 'UsersController@changeSettings'));
    Route::post('settings/password', array('before' => 'auth|csrf', 'uses' => 'UsersController@changePassword'));


    // Confide routes
    Route::get('create', 'UsersController@create');
    Route::post('/', 'UsersController@store');
    Route::get('login', 'UsersController@login');
    Route::post('login', 'UsersController@doLogin');
    Route::get('confirm/{code}', 'UsersController@confirm');
    Route::get('forgot_password', 'UsersController@forgotPassword');
    Route::post('forgot_password', 'UsersController@doForgotPassword');
    Route::get('reset_password/{token}', 'UsersController@resetPassword');
    Route::post('reset_password', 'UsersController@doResetPassword');
    Route::get('logout', 'UsersController@logout');
});

// Admin routes
Route::group(array('prefix' => 'admin'), function(){
    Route::get('/', array('uses' => 'admin\AdminController@index'));

    Route::group(array('prefix' => 'content'), function(){
        Route::get('home', array('uses' => 'admin\ContentController@home'));
        Route::get('about', array('uses' => 'admin\ContentController@about'));
        Route::get('terms', array('uses' => 'admin\ContentController@terms'));
        Route::get('contact', array('uses' => 'admin\ContentController@contact'));

        Route::post('featured', array('uses' => 'admin\ContentController@updateFeatured'));
        Route::post('about', array('uses' => 'admin\ContentController@updateAbout'));
        Route::post('terms', array('uses' => 'admin\ContentController@updateTerms'));
        Route::post('contact', array('uses' => 'admin\ContentController@updateContact'));
    });

    Route::group(array('prefix' => 'recipes'), function(){
        Route::get('/', array('uses' => 'admin\RecipeController@index'));

        Route::get('search/{search_text?}', array('uses' => 'admin\RecipeController@search'));
        Route::post('search/{search_text?}', array('uses' => 'admin\RecipeController@redirectSearch'));

        Route::get('favorites', array('uses' => 'admin\RecipeController@favorites'));

        Route::get('{recipe}/favorite/{favorite?}', array('uses' => 'admin\RecipeController@editFavorite'));
        Route::get('{recipe}', array('uses' => 'admin\RecipeController@show'));
        Route::get('{recipe}/delete', array('uses' => 'admin\RecipeController@delete'));
        Route::post('{recipe}/edit', array('uses' => 'admin\RecipeController@edit'));
    });

    Route::group(array('prefix' => 'category'), function(){
        Route::get('/', array('uses' => 'admin\CategoryController@index'));
        Route::post('create', array('uses' => 'admin\CategoryController@create'));
        Route::get('{category}', array('uses' => 'admin\CategoryController@show'));
        Route::get('{category}/delete', array('uses' => 'admin\CategoryController@delete'));
        Route::post('{category}', array('uses' => 'admin\CategoryController@edit'));
    });

    Route::group(array('prefix' => 'users'), function(){
        Route::get('/', array('uses' => 'admin\UserController@index'));

        Route::get('search/{search_text?}', array('uses' => 'admin\UserController@search'));
        Route::post('search/{search_text?}', array('uses' => 'admin\UserController@redirectSearch'));

        Route::get('{user}', array('uses' => 'admin\UserController@show'));
        Route::get('{user}/delete', array('uses' => 'admin\UserController@delete'));
        Route::post('{user}/edit', array('uses' => 'admin\UserController@edit'));

        Route::get('{user}/recipes', array('uses' => 'admin\RecipeController@fromUser'));
    });

    Route::group(array('prefix' => 'reviews'), function(){
        Route::get('/user/{user}', array('uses' => 'admin\ReviewController@fromUser'));
        Route::get('/recipe/{recipe}', array('uses' => 'admin\ReviewController@forRecipe'));

        Route::get('{review_id}/delete', array('uses' => 'admin\ReviewController@delete'));
    });
});
