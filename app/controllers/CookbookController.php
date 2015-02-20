<?php

class CookbookController extends BaseController {

    public function displayCookbook(User $user){
        if(Input::has('filter')){
            $category = Category::where('name', '=', Input::get('filter'))->first();
        }

        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        if($user->subscribed_recipes){
            $recipe_list = explode(' ', trim($user->subscribed_recipes));
            if(isset($category->id)){
                $recipes = Recipe::whereIn('id', $recipe_list)
                    ->where('category', '=', $category->id)
                    ->where(function($query){
                        $query->where('private', '=', 0)
                            ->orWhere('author_id', '=', Auth::id());
                    })
                    ->orderBy($orderBy, 'desc')
                    ->take(8)->get();
                $total_subscribed = Recipe::whereIn('id', $recipe_list)->where('category', '=', $category->id)->count();
            }
            else{
                $recipes = Recipe::whereIn('id', $recipe_list)
                    ->where(function($query){
                        $query->where('private', '=', 0)
                            ->orWhere('author_id', '=', Auth::id());
                    })
                    ->orderBy($orderBy, 'desc')->take(8)->get();
                $total_subscribed = Recipe::whereIn('id', $recipe_list)->count();
            }

            foreach($recipes as $recipe){
                $recipe->category = Category::find($recipe->category);
                $recipe->user = User::find($recipe->author_id);
                $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
                if(!Auth::guest()){
                    $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
                }
            }
        }
        if(!isset($recipes)){
            $recipes = null;
            $total_subscribed = 0;
        }

        $recipe_stats['total'] = Recipe::where('author_id', '=', $user->id)->count();
        $review_stats['total'] = Review::where('reviewer_id', '=', $user->id)->count();
        $categorys = Category::all();

        return View::make('cookbook')->with(array(
            'user' => $user,
            'recipes' => $recipes,
            'recipe_stats' => $recipe_stats,
            'review_stats' => $review_stats,
            'total_subscribed' => $total_subscribed,
            'categorys' => $categorys
        ));
    }

    public function loadRecipes(User $user, $skip_amount = 0){
        if(Input::has('filter')){
            $category = Category::where('name', '=', Input::get('filter'))->first();
        }

        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        if($user->subscribed_recipes){
            $recipe_list = explode(' ', trim($user->subscribed_recipes));
            if(isset($category->id)) {
                $recipes = Recipe::whereIn('id', $recipe_list)
                    ->where('category', '=', $category->id)
                    ->where(function($query){
                        $query->where('private', '=', 0)
                            ->orWhere('author_id', '=', Auth::id());
                    })
                    ->orderBy($orderBy, 'desc')
                    ->skip($skip_amount)->take(8)->get();
            }
            else{
                $recipes = Recipe::whereIn('id', $recipe_list)
                    ->where(function($query){
                        $query->where('private', '=', 0)
                            ->orWhere('author_id', '=', Auth::id());
                    })
                    ->orderBy($orderBy, 'desc')
                    ->skip($skip_amount)->take(8)->get();
            }
            foreach($recipes as $recipe){
                $recipe->category = Category::find($recipe->category);
                $recipe->user = User::find($recipe->author_id);
                $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
                if(!Auth::guest()){
                    $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
                }
            }
        }

        $response = '';

        foreach($recipes as $recipe){
            $response .= ViewHelper::addRecipe($recipe);
        }

        return $response;
    }

    public function addRecipeToUser(Recipe $recipe){
        if(Auth::user()->addRecipe($recipe->id)){
            $recipe->addSubscriber();
            return 1;
        }
        return 0;
    }

    public function removeRecipeFromUser(Recipe $recipe){
        if(Auth::user()->removeRecipe($recipe->id)){
            $recipe->removeSubscriber();
            return 1;
        }
        return 0;
    }
}
