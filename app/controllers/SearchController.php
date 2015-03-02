<?php

class SearchController extends BaseController {

    public function displaySearchResults($search_text = ''){
        if(Input::has('filter')){
            $category = Category::where('name', '=', Input::get('filter'))->first();
        }

        if(isset($category)){
            $recipes = Recipe::search($search_text, 0, Input::get('sort'), $category->id);
            $total_recipes = Recipe::where('name', 'LIKE', '%'.$search_text.'%')->where('category', '=', $category->id)->count();
        }
        else{
            $recipes = Recipe::search($search_text, 0, Input::get('sort'));
            $total_recipes = Recipe::where('name', 'LIKE', '%'.$search_text.'%')->count();
        }

        foreach($recipes as $recipe){
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }

        $categorys = Category::all();

        return View::make('search.recipe')->with(array(
            'search_text' => $search_text,
            'recipes' => $recipes,
            'total_recipes' => $total_recipes,
            'categorys' => $categorys
        ));
    }

    public function displayUserSearchResults($search_text){
        $users = User::where('username', 'LIKE', '%'.$search_text.'%')->take(12)->get();
        $total_users = User::where('username', 'LIKE', '%'.$search_text.'%')->count();

        foreach($users as $user){
            $user->subscriber_count = Recipe::where('author_id', '=', $user->id)->sum('subscriber_count');
            $user->recipe_count = Recipe::where('author_id', '=', $user->id)->count();
            $user->review_count = Review::where('reviewer_id', '=', $user->id)->count();
        }
        return View::make('search.user')->with(array(
            'search_text' => $search_text,
            'users' => $users,
            'total_users' => $total_users
        ));
    }

    public function redirectSearchResults(){
        $search_text = Input::get('search_text');

        return Redirect::to('search/' . $search_text);
    }

    public function redirectUserSearchResults(){
        $search_text = Input::get('search_text');

        return Redirect::to('search/' . $search_text.'/user');
    }

}
