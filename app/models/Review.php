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
            Event::fire('review_created', array('reviewer_id' => $review->reviewer_id));
        }
        else{
            $review = $review_db;
        }

        if (isset($input['review_image_values'])){
            $image_data = Image::getFrom64($input['review_image_values']);
            if($review->image == ''){
                Event::fire('review_image_added', array('reviewer_id' => $review->reviewer_id));
            }
            $review->image = Auth::user()->username . '-' . $review->recipe_id . '.' . $image_data['extension'];
            Image::store64($image_data['data'], $review->image, 'review_images');
        }
        if($review->image && !isset($input['review_image_values']) && !empty($input['review_image'])){
            $review->image = '';
        }

        $review->rating = $input['rating'];
        $review->text = $input['text'];

        $review->save();
    }
}
