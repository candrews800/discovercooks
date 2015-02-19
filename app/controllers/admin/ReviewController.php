<?php

namespace admin;

use Illuminate\Support\Facades\View;

class ReviewController extends \BaseController {

    public function index(){
        return View::make('admin.review.index');
    }

    public function fromUser(\User $user){
        $reviews = \Review::where('reviewer_id', '=', $user->id)->paginate(25);
        foreach($reviews as $review){
            $review->user = $user;
            $review->recipe = \Recipe::where('id', '=', $review->recipe_id)->first();
        }

        return View::make('admin.review.index')->with(array(
            'reviews' => $reviews
        ));
    }

    public function forRecipe(\Recipe $recipe){
        $reviews = \Review::where('recipe_id', '=', $recipe->id)->paginate(25);
        foreach($reviews as $review){
            $review->user = \User::where('id', '=', $review->reviewer_id)->first();
            $review->recipe = $recipe;
        }

        return View::make('admin.review.index')->with(array(
            'reviews' => $reviews
        ));
    }

    public function delete($review_id){
        $review = \Review::find($review_id);
        $review->delete();

        return \Redirect::back();
    }
}
