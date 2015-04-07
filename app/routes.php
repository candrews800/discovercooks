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

Route::model('topic', 'ForumTopic');
Route::model('post', 'ForumPost');
Route::model('reply', 'ForumReply');


Route::get('/', array('uses' => 'HomeController@displayIndex', 'after' => 'site_view'));
Route::get('/loadRecipes/{skip_amount}', array('uses' => 'HomeController@loadRecipes'));
Route::get('about', array('uses' => 'HomeController@about', 'after' => 'site_view'));
Route::get('earn', array('uses' => 'HomeController@earn', 'after' => 'site_view'));
Route::get('recipe-guidelines', array('uses' => 'HomeController@recipeGuidelines', 'after' => 'site_view'));
Route::get('terms', array('uses' => 'HomeController@terms', 'after' => 'site_view'));
Route::get('style', array('uses' => 'HomeController@style'));

Route::get('contact', array('uses' => 'HomeController@contact', 'after' => 'site_view'));
Route::post('contact', array('before' => 'csrf', 'uses' => 'HomeController@sendContact'));

Route::post('newsletter_signup', array('uses' => 'NewsletterController@add'));

// Search routes
Route::group(array('prefix' => 'search'), function(){
    Route::get('{i?}/user', array('uses' => 'SearchController@displayUserSearchResults', 'after' => 'site_view'));
    Route::get('{i?}', array('uses' => 'SearchController@displaySearchResults', 'after' => 'site_view'));

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
    Route::get('/', array('uses' => 'CategoryController@showAll', 'after' => 'site_view'));
    Route::get('/all', array('uses' => 'CategoryController@showAll', 'after' => 'site_view'));
    Route::get('/all/loadRecipes/{skip_amount}', array('uses' => 'CategoryController@loadAllRecipes'));

    Route::get('/{category}', array('uses' => 'CategoryController@show', 'after' => 'site_view'));
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
    Route::post('/{user}/editPicture', array('before' => 'auth|matches_logged_in', 'uses' => 'ProfileController@changePicture'));
});

// Cookbook routes
Route::group(array('prefix' => 'cookbook'), function(){
    Route::get('/addRecipe/{recipe}', array('before' => 'auth', 'uses' => 'CookbookController@addRecipeToUser'));
    Route::get('/removeRecipe/{recipe}', array('before' => 'auth', 'uses' => 'CookbookController@removeRecipeFromUser'));
    Route::get('/{user}', array('uses' => 'CookbookController@displayCookbook'));
    Route::get('/{user}/loadRecipes/{skip_amount}', array('uses' => 'CookbookController@loadRecipes'));
});

// Account routes
Route::group(array('prefix' => 'account', 'before' => 'auth'), function(){
    Route::get('/', array('uses' => 'AccountController@index'));
    Route::get('edit', array('uses' => 'AccountController@edit'));
    Route::post('edit', array('uses' => 'AccountController@doEdit'));

    Route::get('stats', array('uses' => 'AccountController@stats'));
    Route::get('stats/recipes', array('uses' => 'AccountController@recipeStats'));
    Route::get('stats/reviews', array('uses' => 'AccountController@reviewStats'));

    Route::get('stats/archive', array('uses' => 'AccountController@archive'));

    Route::get('payments', array('uses' => 'AccountController@payments'));
    Route::post('payments/setUp', array('uses' => 'AccountController@paymentsSetup'));
    Route::post('payments/createPayout', array('uses' => 'AccountController@createPayout'));
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

// Forum routes
Route::group(array('prefix' => 'forum'), function() {
    Route::get('/', array('uses' => 'forum\ForumController@index', 'after' => 'site_view'));

    Route::get('/reply/{reply}/delete', array('before' => 'auth|admin', 'uses' => 'forum\ReplyController@delete'));
    Route::get('/reply/{reply}', array('before' => 'auth', 'uses' => 'forum\ReplyController@show'));
    Route::post('/reply/{reply}', array('before' => 'auth', 'uses' => 'forum\ReplyController@edit'));

    Route::get('/topic/{topic}', array('uses' => 'forum\TopicController@show', 'after' => 'site_view'));

    Route::get('/topic/{topic}/create', array('before' => 'auth', 'uses' => 'forum\PostController@showCreate'));
    Route::get('/post/{post}/edit', array('before' => 'auth', 'uses' => 'forum\PostController@showEdit'));
    Route::get('/post/{post}/delete', array('before' => 'auth|admin', 'uses' => 'forum\PostController@delete'));
    Route::get('/post/{post}/addSticky', array('before' => 'auth|admin', 'uses' => 'forum\PostController@addSticky'));
    Route::get('/post/{post}/removeSticky', array('before' => 'auth|admin', 'uses' => 'forum\PostController@removeSticky'));
    Route::get('/post/{post}/addLocked', array('before' => 'auth|admin', 'uses' => 'forum\PostController@addLocked'));
    Route::get('/post/{post}/removeLocked', array('before' => 'auth|admin', 'uses' => 'forum\PostController@removeLocked'));
    Route::post('/post/{post}/edit', array('before' => 'auth', 'uses' => 'forum\PostController@edit'));

    Route::get('/post/{post}', array('uses' => 'forum\PostController@show', 'after' => 'site_view'));

    Route::post('/topic/{topic}/create', array('before' => 'auth|csrf', 'uses' => 'forum\PostController@create'));
    Route::post('/post/{post}/addReply', array('uses' => 'forum\ReplyController@create'));
});


// Admin routes
Route::group(array('prefix' => 'admin'), function(){
    Route::get('/', array('uses' => 'admin\AdminController@index'));

    Route::get('newsletter', array('uses' => 'admin\NewsletterController@index'));

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

        Route::get('needReview', array('uses' => 'admin\RecipeController@needReview'));

        Route::get('approve/{recipe_id}', array('uses' => 'admin\RecipeController@approve'));
        Route::get('deny/{recipe_id}', array('uses' => 'admin\RecipeController@deny'));

        Route::get('favorites', array('uses' => 'admin\RecipeController@favorites'));
        Route::get('ingredientSizes', array('uses' => 'admin\RecipeController@ingredientSizes'));
        Route::get('ingredientSizes/edit/{id}', array('uses' => 'admin\RecipeController@editIngredientSize'));
        Route::get('ingredientSizes/delete/{id}', array('uses' => 'admin\RecipeController@deleteIngredientSize'));

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

    Route::group(array('prefix' => 'forum'), function(){
        Route::group(array('prefix' => 'categories'), function(){
            Route::get('/', array('uses' => 'admin\forum\CategoryController@all'));
            Route::get('updatePosition', array('uses' => 'admin\forum\CategoryController@updatePositions'));
            Route::get('delete/{category_id}', array('uses' => 'admin\forum\CategoryController@delete'));

            Route::post('/', array('uses' => 'admin\forum\CategoryController@create'));
            Route::post('edit/{category_id}', array('uses' => 'admin\forum\CategoryController@edit'));
        });

        Route::group(array('prefix' => 'topics'), function(){
            Route::get('/', array('uses' => 'admin\forum\TopicController@all'));
            Route::get('updatePosition', array('uses' => 'admin\forum\TopicController@updatePositions'));
            Route::get('editDescription/{topic_id}', array('uses' => 'admin\forum\TopicController@editDescription'));
            Route::get('updateCategory/{topic_id}', array('uses' => 'admin\forum\TopicController@updateCategory'));
            Route::get('delete/{topic_id}', array('uses' => 'admin\forum\TopicController@delete'));

            Route::post('/', array('uses' => 'admin\forum\TopicController@create'));
            Route::post('edit/{topic_id}', array('uses' => 'admin\forum\TopicController@edit'));
        });
    });

    Route::group(array('prefix' => 'stats'), function(){
        Route::get('overall', array('uses' => 'admin\StatsController@overall'));
        Route::get('users', array('uses' => 'admin\StatsController@users'));
        Route::get('recipes', array('uses' => 'admin\StatsController@recipes'));
        Route::get('reviews', array('uses' => 'admin\StatsController@reviews'));
    });

    Route::group(array('prefix' => 'payments'), function(){
        Route::get('balances', array('uses' => 'admin\PaymentController@siteBalances'));

        Route::get('make', array('uses' => 'admin\PaymentController@creditAccounts'));
        Route::post('make', array('uses' => 'admin\PaymentController@doCreditAccounts'));

        Route::get('paymentQueue', array('uses' => 'admin\PaymentController@paymentQueue'));
        Route::get('paymentQueue/{queue_id}', array('uses' => 'admin\PaymentController@processQueueItem'));
    });
});
