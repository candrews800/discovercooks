<?php

class HelpfulReview extends Eloquent{
    public $timestamps = false;
    protected $table = 'helpfulreviews';

    public function make(Recipe $recipe, Review $review, $isHelpful){
        if($this->id && $this->isHelpful != $isHelpful){
            if($isHelpful){
                $review->non_helpful--;
                $review->helpful++;
            }
            else{
                $review->helpful--;
                $review->non_helpful++;
            }
            $review->save();
        }
        else if(!$this->id){
            if($isHelpful){
                $review->helpful++;
            }
            else{
                $review->non_helpful++;
            }
            $review->save();
        }

        $this->recipe_id = $recipe->id;
        $this->review_id = $review->id;
        $this->user_id = Auth::id();
        $this->isHelpful = $isHelpful;

        return $this->save();
    }
}
