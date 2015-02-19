<?php

class Review extends Eloquent{

    public static $defaultReviewCount = 6;

    public static function add($input){

        $review_db = Review::where('reviewer_id' ,'=', Auth::id())
                             ->where('recipe_id', '=', $input['recipe_id'])->first();

        if(!$review_db){
            $review = new Review;
            $review->reviewer_id = Auth::id();
            $review->recipe_id = $input['recipe_id'];
        }
        else{
            $review = $review_db;
        }

        $review->rating = $input['rating'];
        $review->text = $input['text'];

        $review->save();
    }
}
