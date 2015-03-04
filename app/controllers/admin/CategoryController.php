<?php

namespace admin;

use Illuminate\Support\Facades\View;

class CategoryController extends \BaseController {

    public function index(){
        $categories = \Category::paginate(25);
        foreach($categories as $category){
            $category->recipe_count = \Recipe::where('category', '=', $category->id)->count();
        }

        return View::make('admin.category.index')->with(array(
            'categories' => $categories
        ));
    }

    public function show($category){
        $category = \Category::where('name', '=', $category)->first();
        $category->recipe = \Recipe::where('id', '=', $category->related_recipe_id);
        $related_favorites = \Recipe::join('favorite_recipes', 'recipes.id', '=', 'favorite_recipes.recipe_id')->where('category', '=', $category->id)->get();
        $related_recipes = array();
        foreach($related_favorites as $recipe){
            $related_recipes[$recipe->recipe_id] = $recipe->name;
        }

        return View::make('admin.category.single')->with(array(
            'category' => $category,
            'related_recipes' => $related_recipes
        ));
    }

    public function edit($category){
        $input = \Input::all();
        $category = \Category::where('name', '=', $category)->first();

        $category->name = $input['name'];
        if($input['related_recipe_id']){
            $category->related_recipe_id = $input['related_recipe_id'];
        }

        if (isset($input['category_image_values'])){
            $image_data = \Image::getFrom64($input['category_image_values']);
            $category->image = $category->name . '.' . $image_data['extension'];
            \Image::store64($image_data['data'], $category->image, 'category_images');
            dd('t');
        }
        if($category->image && !isset($input['category_image_values']) && !empty($input['category_image'])){
            $category->image = '';
        }

        $category->save();

        return \Redirect::to('admin/category/'.$category->name);
    }

    public function create(){
        $input = \Input::all();

        $category = new \Category();
        $category->name = $input['name'];
        $category->save();

        return \Redirect::back();
    }

    public function delete($category){
        $category = \Category::where('name', '=', $category)->first();
        $category->delete();

        return \Redirect::back();
    }
}
