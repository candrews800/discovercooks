<?php

class RecipeController extends BaseController {

    public function addRecipeToUser(Recipe $recipe){
        if(Auth::user()->addRecipe($recipe->id)){
            $recipe->addSubscriber();
        }
        return Redirect::back();
    }

    public function removeRecipeFromUser(Recipe $recipe){
        if(Auth::user()->removeRecipe($recipe->id)){
            $recipe->removeSubscriber();
        }
        return Redirect::back();
    }

    public function displayEdit(Recipe $recipe = null){
        if(!$recipe){
            $recipe = new Recipe();
        }
        $categories = Category::getSelectList();

        if($recipe->prep_time){
            $prep_time = explode(' ', $recipe->prep_time);
            $recipe->prep_time = $prep_time[0];
            $recipe->prep_time_type = $prep_time[1];
        }

        if($recipe->cook_time){
            $cook_time = explode(' ', $recipe->cook_time);
            $recipe->cook_time = $cook_time[0];
            $recipe->cook_time_type = $cook_time[1];
        }

        if($recipe->total_time){
            $total_time = explode(' ', $recipe->total_time);
            $recipe->total_time = $total_time[0];
            $recipe->total_time_type = $total_time[1];
        }

        $recipe->category = Category::find($recipe->category);

        return View::make('editRecipe')->with(array('recipe' => $recipe, 'categories' => $categories));
    }

    public function loadRecipes($search_term, $skip_amount = 0){
        if(Input::has('filter')){
            $category = Category::where('name', '=', Input::get('filter'))->first();
        }

        if(isset($category)){
            $recipes = Recipe::search($search_term, $skip_amount, Input::get('sort'), $category->id);
        }
        else{
            $recipes = Recipe::search($search_term, $skip_amount, Input::get('sort'));
        }

        $response = '';

        foreach($recipes as $recipe){
            $response .= ViewHelper::addRecipe($recipe);
        }

        return $response;
    }

    public function saveRecipe(Recipe $recipe = null){
        $input = Input::all();

        if($recipe){
            Recipe::$rules['name'] .= "|unique:recipes,name,".$recipe->id;
        }
        $validator = Validator::make($input, Recipe::$rules);

        if ($validator->fails()){
            if($recipe == null){
                return Redirect::back()->withErrors($validator)->withInput();
            }
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else{
            if($recipe){
                $recipe = $recipe->edit($input);
            }
            else{
                $recipe = Recipe::make($input);
            }

            if(Auth::user()->addRecipe($recipe->id)){
                $recipe->addSubscriber();
            }

            return Redirect::to('recipe/' . $recipe->slug)->with(array('recipe' => $recipe));
        }
    }

    public function show(Recipe $recipe){
        // Recipe Privacy Check
        if($recipe->private && $recipe->author_id != Auth::id()){
            return App::abort(404);
        }

        if(!Auth::guest()){
            $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
        }
        $related_recipes = Recipe::where('category', '=', $recipe->category)->take(4)->get();
        foreach($related_recipes as $related_recipe){
            $related_recipe->user = User::find($related_recipe->author_id);
            $related_recipe->review_count = Review::where('recipe_id', '=', $related_recipe->id)->count();
            if(!Auth::guest()){
                $related_recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }
        $author = User::find($recipe->author_id);
        $category = Category::find($recipe->category);
        $reviews = Review::where('recipe_id', '=', $recipe->id)->take(Review::$defaultReviewCount)->get();
        $total_reviews = Review::where('recipe_id', '=', $recipe->id)->count();
        $user_review = new Review;
        $user_review->rating = 0;
        if(Auth::id()){
            $user_review = Review::where('reviewer_id' ,'=', Auth::id())
                ->where('recipe_id', '=', $recipe->id)->first();
            if(!$user_review){
                $user_review = new Review;
                $user_review->rating = 0;
            }
        }

        if($reviews->isEmpty()){
            return View::make('singleRecipe')->with(array(
                'recipe' => $recipe,
                'author' => $author,
                'category' => $category,
                'reviews' => $reviews,
                'user_review' => $user_review,
                'total_reviews' => $total_reviews,
                'related_recipes' => $related_recipes
            ));
        }

        foreach($reviews as $review){
            $review->author = User::find($review->reviewer_id);

            if(Auth::id()){
                $helpful = HelpfulReview::where('recipe_id', '=', $recipe->id)
                    ->where('review_id', '=', $review->id)
                    ->where('user_id', '=', Auth::id())->first();
                if($helpful){
                    $review->helpful = $helpful->isHelpful;
                }
                else{
                    $review->helpful = '';
                }
            }
        }

        $positive_review = Review::orderBy('rating', 'desc')->orderBy('helpful', 'desc')->first();
        $positive_review->author = User::find($positive_review->reviewer_id);
        $helpful = HelpfulReview::where('recipe_id', '=', $recipe->id)
            ->where('review_id', '=', $positive_review->id)
            ->where('user_id', '=', Auth::id())->first();
        if($helpful){
            $positive_review->helpful = $helpful->isHelpful;
        }
        else{
            $positive_review->helpful = '';
        }

        $critical_review = Review::orderBy('rating', 'asc')->orderBy('helpful', 'desc')->first();
        $critical_review->author = User::find($critical_review->reviewer_id);
        $helpful = HelpfulReview::where('recipe_id', '=', $recipe->id)
            ->where('review_id', '=', $critical_review->id)
            ->where('user_id', '=', Auth::id())->first();
        if($helpful){
            $critical_review->helpful = $helpful->isHelpful;
        }
        else{
            $critical_review->helpful = '';
        }

        $review_distribution['total'] = Review::where('recipe_id', '=', $recipe->id)->count();
        $review_distribution[1] = Review::where('recipe_id', '=', $recipe->id)->where('rating', '=', '1')->count() / $review_distribution['total'] * 100;
        $review_distribution[2] = Review::where('recipe_id', '=', $recipe->id)->where('rating', '=', '2')->count() / $review_distribution['total'] * 100;
        $review_distribution[3] = Review::where('recipe_id', '=', $recipe->id)->where('rating', '=', '3')->count() / $review_distribution['total'] * 100;
        $review_distribution[4] = Review::where('recipe_id', '=', $recipe->id)->where('rating', '=', '4')->count() / $review_distribution['total'] * 100;
        $review_distribution[5] = Review::where('recipe_id', '=', $recipe->id)->where('rating', '=', '5')->count() / $review_distribution['total'] * 100;


        return View::make('singleRecipe')->with(array(
            'recipe' => $recipe,
            'author' => $author,
            'category' => $category,
            'reviews' => $reviews,
            'total_reviews' => $total_reviews,
            'user_review' => $user_review,
            'positive_review' => $positive_review,
            'critical_review' => $critical_review,
            'review_distribution' => $review_distribution,
            'related_recipes' => $related_recipes
        ));
    }
}