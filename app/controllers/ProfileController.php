<?php

class ProfileController extends BaseController {

    public function changePicture(User $user){
        $input = Input::all();
        if (isset($input['data'])){
            $image_data = Image::getFrom64($input['data']);
            $user->image = $user->username . '.' . $image_data['extension'];
            Image::store64($image_data['data'], $user->image, 'user_images');
        }

        $user->save();

        return Response::json(array(
           'status' => 'success',
            'url' => url('/user_images/'.$user->image),
            'filename' => $user->image
        ));
    }

    public function doEdit(User $user){
        $input = Input::all();
        $rules = array(
            'username' =>   'required|min:3|max:24|unique:users,username,'.$user->id,
            'email'    =>   'required|max:100|email|unique:users,email,'.$user->id,
            'facebook' => 'url|max:100|regex:/^(http(s)?:\/\/)?(www.)?facebook.com\/(.)+$/',
            'twitter' => 'url|max:100|regex:/^(http(s)?:\/\/)?(www.)?twitter.com\/(.)+$/',
            'pinterest' => 'url|max:100|regex:/^(http(s)?:\/\/)?(www.)?pinterest.com\/(.)+$/',
            'website' => 'url|max:100',
            'hometown' => 'max:30',
            'location' => 'max:30',
            'hobbies' => 'max:45'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = $user->edit($input);

        return Redirect::to('profile/'.$user->username.'/edit');
    }

    public function deleteImage(User $user){
        $user->image = '';
        $user->save();
    }

    public function loadRecipes(User $user, $skip_amount = 0){
        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        if(Input::has('filter')){
            $category = Category::where('name', '=', Input::get('filter'))->first();
        }

        if(isset($category)){
            $recipes = Recipe::where('author_id', '=', $user->id)
                ->where('category', '=', $category->id)
                ->where(function($query){
                    $query->where('private', '=', 0)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->where(function($query){
                    $query->where('approved', '=', 1)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->orderBy($orderBy, 'desc')
                ->skip($skip_amount)->take(8)->get();
        }
        else{
            $recipes = Recipe::where('author_id', '=', $user->id)
                ->where(function($query){
                    $query->where('private', '=', 0)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->where(function($query){
                    $query->where('approved', '=', 1)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->orderBy($orderBy, 'desc')
                ->skip($skip_amount)->take(8)->get();
        }

        $response = '';

        foreach($recipes as $recipe){
            $recipe->user = $user;
            $recipe->category = Category::find($recipe->category);
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
            $response .= ViewHelper::addRecipe($recipe);
        }

        return $response;
    }

    public function loadReviews(User $user, $skip_amount = 0){
        $reviews = Review::where('reviewer_id', '=', $user->id)->skip($skip_amount)->take(8)->get();

        $response = '';

        foreach($reviews as $review){
            $review->recipe = Recipe::find($review->recipe_id);
            $review->user = User::find($review->recipe->author_id);
            $review->total_helpful = $review->helpful + $review->non_helpful;
            $response .= ViewHelper::addProfileReview($review);
        }

        return $response;
    }

    public function show(User $user){

        Event::fire('user_view', array('user_id' => $user->id));

        $recent_reviews = Recipe::join('reviews', 'recipes.id', '=', 'reviews.recipe_id')->where('recipes.author_id', '=', $user->id)->take(4)->get();
        foreach($recent_reviews as $review){
            $review->reviewer = User::find($review->reviewer_id);
        }

        $recipes = Recipe::where('author_id', '=', $user->id)
            ->where(function($query){
                $query->where('private', '=', 0)
                    ->orWhere('author_id', '=', Auth::id());
            })
            ->where(function($query){
                $query->where('approved', '=', 1)
                    ->orWhere('author_id', '=', Auth::id());
            })
            ->orderBy('overall_rating', 'desc')
            ->take(3)->get();
        foreach($recipes as $recipe){
            $recipe->user = User::find($recipe->author_id);
            $recipe->category = Category::find($recipe->category);
            $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }



        $reviews = Review::where('reviewer_id', '=', $user->id)->take(6)->get();
        foreach($reviews as $review){
            $review->recipe = Recipe::find($review->recipe_id);
            $review->total_helpful = $review->helpful + $review->non_helpful;
        }

        if($user->subscribed_recipes){
            $total_cookbook = sizeof(explode(' ', trim($user->subscribed_recipes)));
        }
        else{
            $total_cookbook = 0;
        }

        return View::make('profile.index')->with(array(
            'user' => $user,
            'recipes' => $recipes,
            'recent_reviews' => $recent_reviews,
            'reviews' => $reviews,
            'total_cookbook' => $total_cookbook
        ));
    }

    public function showEdit(User $user){
        return View::make('profile.edit')->with(array('user' => $user));
    }

    public function showRecipes(User $user){
        Event::fire('user_view', array('user_id' => $user->id));
        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        if(Input::has('filter')){
            $category = Category::where('name', '=', Input::get('filter'))->first();
        }

        if(isset($category)){
            $recipes = Recipe::where('author_id', '=', $user->id)
                ->where('category', '=', $category->id)
                ->where(function($query){
                    $query->where('private', '=', 0)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->where(function($query){
                    $query->where('approved', '=', 1)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->orderBy($orderBy, 'desc')
                ->take(8)->get();
            $total_recipes = Recipe::where('author_id', '=', $user->id)->where('category', '=', $category->id)->count();
        }
        else{
            $recipes = Recipe::where('author_id', '=', $user->id)
                ->where(function($query){
                    $query->where('private', '=', 0)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->where(function($query){
                    $query->where('approved', '=', 1)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->orderBy($orderBy, 'desc')
                ->take(8)->get();
            $total_recipes = Recipe::where('author_id', '=', $user->id)->count();
        }

        foreach($recipes as $recipe){
            $recipe->category = Category::find($recipe->category);
            $recipe->user = $user;
            $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }

        $categorys = Category::all();

        return View::make('profile.recipes')->with(array(
            'user' => $user,
            'recipes' => $recipes,
            'categorys' => $categorys,
            'total_recipes' => $total_recipes
        ));
    }

    public function showReviews(User $user){
        Event::fire('user_view', array('user_id' => $user->id));
        $recipe_stats['total'] = Recipe::where('author_id', '=', $user->id)->count();
        $review_stats['total'] = Review::where('reviewer_id', '=', $user->id)->count();
        $review_stats['helpful'] = Review::where('reviewer_id', '=', $user->id)->sum('helpful') - Review::where('reviewer_id', '=', $user->id)->sum('non_helpful');

        $reviews = Review::where('reviewer_id', '=', $user->id)->take(8)->get();
        foreach($reviews as $review){
            $review->recipe = Recipe::find($review->recipe_id);
            $review->total_helpful = $review->helpful + $review->non_helpful;
            $review->user = $user;
        }

        return View::make('profile.reviews')->with(array(
            'user' => $user,
            'reviews' => $reviews,
        ));
    }
}
