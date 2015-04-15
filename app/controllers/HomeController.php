<?php

class HomeController extends BaseController {

    public function displayIndex(){
        $featured_recipes = \Recipe::join('featured_recipes', 'recipes.id', '=', 'featured_recipes.recipe_id')->get();
        foreach($featured_recipes as $recipe){
            $recipe->category = Category::find($recipe->category);
            $recipe->author = User::where('id', '=', $recipe->author_id)->first();
        }

        $categories = Category::all();
        foreach($categories as $category){
            $category->recipe = Recipe::find($category->related_recipe_id);
            if($category->recipe){
                $category->user = User::find($category->recipe->author_id);
            }
        }

        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        $recipes = Recipe::orderBy($orderBy, 'desc')
            ->where(function($query){
                $query->where('private', '=', 0)
                    ->orWhere('author_id', '=', Auth::id());
            })
            ->where(function($query){
                $query->where('approved', '=', 1)
                    ->orWhere('author_id', '=', Auth::id());
            })
            ->take(24)->get();
        $total_recipes = Recipe::count();

        foreach($recipes as $recipe){
            $recipe->category = Category::find($recipe->category);
            $recipe->user = User::find($recipe->author_id);
            $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
            if(!Auth::guest()){
                $recipe->isSaved = Auth::user()->hasRecipe($recipe->id);
            }
        }

        $blog_posts = BlogPost::orderBy('id', 'desc')->take(5)->get();

        return View::make('index')->with(array(
            'featured_recipes' => $featured_recipes,
            'categories' => $categories,
            'recipes' => $recipes,
            'total_recipes' => $total_recipes,
            'blog_posts' => $blog_posts
        ));
    }

    public function loadRecipes($skip_amount = 0){
        $orderBy = 'overall_rating';
        if(Input::get('sort') == 'new'){
            $orderBy = 'created_at';
        }
        else if(Input::get('sort') == 'popularity'){
            $orderBy = 'subscriber_count';
        }

        $recipes = Recipe::orderBy($orderBy, 'desc')
            ->where(function($query){
                $query->where('private', '=', 0)
                    ->orWhere('author_id', '=', Auth::id());
            })
            ->where(function($query){
                $query->where('approved', '=', 1)
                    ->orWhere('author_id', '=', Auth::id());
            })
            ->skip($skip_amount)->take(12)->get();

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

    public function about(){
        $about = DB::table('about')->first();

        return View::make('content.about')->with(array(
            'about' => $about
        ));
    }

    public function earn(){
        return View::make('content.earn')->with(array(

        ));
    }

    public function recipeGuidelines(){
        return View::make('content.recipeGuidelines')->with(array(

        ));
    }

    public function terms(){
        $terms = DB::table('terms')->first();

        return View::make('content.terms')->with(array(
            'terms' => $terms
        ));
    }

    public function contact(){
        return View::make('content.contact');
    }

    public function style(){
        return View::make('style.index');
    }

    public function sendContact(){
        $input = Input::all();
        $contact = DB::table('contact')->first();

        Mail::send('emails.contact', array('input' => $input), function($message) use ($contact)
        {
            $message->to($contact->email, 'Clinton Andrews')->subject('Message From Website');
        });

        Session::put('message_sent', true);
        return Redirect::back();
    }
}
