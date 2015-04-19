<?php

namespace admin;

use Illuminate\Support\Facades\View;

class RecipeController extends \BaseController {

    public function index(){
        $recipes = \Recipe::paginate(25);
        foreach($recipes as $recipe){
            $recipe->isFavorite = \FavoriteRecipe::where('recipe_id', '=', $recipe->id)->count();
            $recipe->review_count = \Review::where('recipe_id', '=', $recipe->id)->count();
        }

        return \View::make('admin.recipe.index')->with(array(
            'recipes' => $recipes
        ));
    }

    public function redirectSearch($search_text = null){
        if(\Input::has('search_text')){
            $search_text = \Input::get('search_text');
            return \Redirect::to('admin/recipes/search/'.$search_text);
        }
        return \Redirect::to('admin/recipes');

    }

    public function search($search_text = null){
        if(\Input::has('search_text')){
            $search_text = \Input::get('search_text');
        }
        if(!$search_text){
            return \Redirect::to('admin/recipes');
        }

        $recipes = \Recipe::where('name', 'LIKE', '%'.$search_text.'%')->paginate(25);
        foreach($recipes as $recipe){
            $recipe->isFavorite = \FavoriteRecipe::where('recipe_id', '=', $recipe->id)->count();
            $recipe->review_count = \Review::where('recipe_id', '=', $recipe->id)->count();
        }

        return View::make('admin.recipe.index')->with(array(
            'search_text' => $search_text,
            'recipes' => $recipes
        ));
    }

    public function favorites(){
        $recipes = \Recipe::join('favorite_recipes', 'recipes.id', '=', 'favorite_recipes.recipe_id')->paginate(25);
        foreach($recipes as $recipe){
            $recipe->isFavorite = 1;
            $recipe->review_count = \Review::where('recipe_id', '=', $recipe->id)->count();
        }

        return View::make('admin.recipe.index')->with(array(
           'recipes' => $recipes
        ));
    }

    public function editFavorite(\Recipe $recipe, $favorite = 0){
        if($favorite){
            if(\FavoriteRecipe::where('recipe_id', '=', $recipe->id)->count()){
                return \Redirect::back();
            }
            $fav = new \FavoriteRecipe;
            $fav->recipe_id = $recipe->id;
            $fav->save();
            return \Redirect::back();
        }

        \FavoriteRecipe::where('recipe_id', '=', $recipe->id)->delete();
        return \Redirect::back();
    }

    public function show(\Recipe $recipe){
        $categories = \Category::getSelectList();

        $prep_time = explode(' ', $recipe->prep_time);
        $recipe->prep_time = $prep_time[0];
        $recipe->prep_time_type = $prep_time[1];

        $cook_time = explode(' ', $recipe->cook_time);
        $recipe->cook_time = $cook_time[0];
        $recipe->cook_time_type = $cook_time[1];

        $total_time = explode(' ', $recipe->total_time);
        $recipe->total_time = $total_time[0];
        $recipe->total_time_type = $total_time[1];

        return View::make('admin.recipe.single')->with(array(
           'recipe' => $recipe,
            'categories' => $categories
        ));
    }

    public function edit(\Recipe $recipe){
        $input = \Input::all();

        \Recipe::$rules['name'] .= "|unique:recipes,name,".$recipe->id;
        $validator = \Validator::make($input, \Recipe::$rules);

        if ($validator->fails()){
            return \Redirect::back()->withErrors($validator)->withInput();
        }
        $recipe = $recipe->edit($input);

        return \Redirect::to('admin/recipes/' . $recipe->slug)->with(array('recipe' => $recipe));
    }

    public function delete(\Recipe $recipe){
        $recipe->delete();

        return \Redirect::back();
    }

    public function fromUser(\User $user){
        $recipes = \Recipe::where('author_id','=',$user->id)->paginate(25);
        foreach($recipes as $recipe){
            $recipe->isFavorite = \FavoriteRecipe::where('recipe_id', '=', $recipe->id)->count();
            $recipe->review_count = \Review::where('recipe_id', '=', $recipe->id)->count();
        }

        return \View::make('admin.recipe.index')->with(array(
            'recipes' => $recipes
        ));
    }

    public function ingredientSizes(){
        $ingredient_sizes = \IngredientSizes::all();
        $name = \Input::get('name');
        if($name && \IngredientSizes::where('name', '=', $name)->count() == 0){
            $ingredient = new \IngredientSizes();
            $ingredient->name = $name;
            $ingredient->save();
        }
        if($name){
            return \Redirect::to(\Request::path());
        }

        return \View::make('admin.recipe.ingredientSizes')->with(array(
            'ingredient_sizes' => $ingredient_sizes
        ));
    }

    public function editIngredientSize($id){
        $ingredient_size = \IngredientSizes::find($id);
        $ingredient_size->name = \Input::get('name');
        $ingredient_size->save();

        return \Redirect::back();
    }

    public function deleteIngredientSize($id){
        $ingredient_size = \IngredientSizes::find($id);
        $ingredient_size->delete();

        return \Redirect::back();
    }

    public function needReview(){

        $recipes = \Recipe::where('reviewed', '=', 0)->orderBy('updated_at', 'asc')->get();

        return View::make('admin.recipe.needReview')->with(array(
            'recipes' => $recipes
        ));
    }

    public function approve($recipe_id){
        $recipe = \Recipe::find($recipe_id);
        $recipe->reviewed = 1;
        $recipe->approved = 1;
        Event::fire('recipe_approved', array('user_id' => $recipe->author_id));
        $recipe->save();
        return \Redirect::back();
    }

    public function deny($recipe_id){
        $recipe = \Recipe::find($recipe_id);
        $recipe->reviewed = 1;
        $recipe->approved = 0;
        $recipe->save();
        return \Redirect::back();
    }
}
