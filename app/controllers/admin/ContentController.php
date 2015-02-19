<?php

namespace admin;

use Illuminate\Support\Facades\View;

class ContentController extends \BaseController {

    public function home(){
        $favorite_recipes = \Recipe::join('favorite_recipes', 'recipes.id', '=', 'favorite_recipes.recipe_id')->get();
        $favorite_recipes_dropdown = array();
        foreach($favorite_recipes as $recipe){
            $favorite_recipes_dropdown[$recipe->recipe_id] = $recipe->name;
        }

        $featured_recipes = \FeaturedRecipe::all();

        return View::make('admin.content.home')->with(array(
            'favorite_recipes' => $favorite_recipes,
            'favorite_recipes_dropdown' => $favorite_recipes_dropdown,
            'featured_recipes' => $featured_recipes
        ));
    }

    public function updateFeatured(){
        $input = \Input::all();

        $featured_recipes = \FeaturedRecipe::all();

        foreach($featured_recipes as $key=>$recipe){
            $key = 'featured_'.($key+1);
            $recipe->recipe_id = $input[$key];
            $recipe->save();
        }

        return \Redirect::back();
    }

    public function about(){
        $about = \DB::table('about')->first();

        return View::make('admin.content.about')->with(array(
            'about' => $about
        ));
    }

    public function updateAbout(){
        $text = \Input::get('text');
        \DB::table('about')->update(array(
            'text' => $text
        ));

        return \Redirect::back();
    }

    public function terms(){
        $terms = \DB::table('terms')->first();

        return View::make('admin.content.terms')->with(array(
            'terms' => $terms
        ));
    }

    public function updateTerms(){
        $text = \Input::get('text');
        \DB::table('terms')->update(array(
            'text' => $text
        ));

        return \Redirect::back();
    }

    public function contact(){
        $contact = \DB::table('contact')->first();

        return View::make('admin.content.contact')->with(array(
            'contact' => $contact
        ));
    }

    public function updateContact(){
        $email = \Input::get('email');
        \DB::table('contact')->update(array(
            'email' => $email
        ));

        return \Redirect::back();
    }
}
