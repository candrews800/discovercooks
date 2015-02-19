<?php

class CategoryController extends BaseController {

    public function showAll(){
        $featured_recipe = \Recipe::join('featured_recipes', 'recipes.id', '=', 'featured_recipes.recipe_id')->first();
        $featured_recipe->author = User::find($featured_recipe->author_id);

        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        $recipes = Recipe::orderBy($orderBy, 'desc')->take(8)->get();
        $total_recipes = Recipe::orderBy($orderBy, 'desc')->count();

        foreach($recipes as $recipe){
            $recipe->category = Category::find($recipe->category);
            $recipe->user = User::find($recipe->author_id);
            $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }

        $category = new Category();
        $category->name = 'all';

        return View::make('category')->with(array(
            'category' => $category,
            'featured_recipe' => $featured_recipe,
            'recipes' => $recipes,
            'total_recipes' => $total_recipes
        ));
    }

    public function loadAllRecipes($skip_amount = 0){
        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        $recipes = Recipe::orderBy($orderBy, 'desc')->skip($skip_amount)->take(8)->get();

        $response = '';

        foreach($recipes as $recipe){
            $recipe->category = Category::find($recipe->category);
            $recipe->user = User::find($recipe->author_id);
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
            $response .= ViewHelper::addRecipe($recipe);
        }

        return $response;
    }

    public function show($category){
        $category = Category::where('name', '=', $category)->first();
        if(!$category){
            App::abort(404);
        }

        $featured_recipe = Recipe::find($category->related_recipe_id);
        $featured_recipe->author = User::find($featured_recipe->author_id);

        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        $recipes = Recipe::where('category', '=', $category->id)->orderBy($orderBy, 'desc')->take(8)->get();
        $total_recipes = Recipe::where('category', '=', $category->id)->count();

        foreach($recipes as $recipe){
            $recipe->category = $category;
            $recipe->user = User::find($recipe->author_id);
            $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }

        return View::make('category')->with(array(
            'category' => $category,
            'featured_recipe' => $featured_recipe,
            'recipes' => $recipes,
            'total_recipes' => $total_recipes
        ));
    }

    public function loadRecipes($category, $skip_amount = 0){
        $category = Category::where('name', '=', $category)->first();
        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        $recipes = Recipe::where('category', '=', $category->id)->orderBy($orderBy, 'desc')->skip($skip_amount)->take(8)->get();

        $response = '';

        foreach($recipes as $recipe){
            $recipe->category = $category;
            $recipe->user = User::find($recipe->author_id);
            $response .= ViewHelper::addRecipe($recipe);
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }

        return $response;
    }
}
