<?php

class HelpfulReview extends Eloquent{
    public $timestamps = false;
    protected $table = 'helpfulreviews';

    public function make(Recipe $recipe, Review $review, $isHelpful){
        if($this->id && $this->isHelpful != $isHelpful){
            if($isHelpful){
                UserStats::addHelpful($recipe->author_id);
                UserStats::removeNonHelpful($recipe->author_id);
                WeeklyStats::addHelpful($recipe->author_id);
                WeeklyStats::removeNonHelpful($recipe->author_id);
                $review->non_helpful--;
                $review->helpful++;
            }
            else{
                UserStats::removeHelpful($recipe->author_id);
                UserStats::addNonHelpful($recipe->author_id);
                WeeklyStats::removeHelpful($recipe->author_id);
                WeeklyStats::addNonHelpful($recipe->author_id);
                $review->helpful--;
                $review->non_helpful++;
            }
            $review->save();
        }
        else if(!$this->id){
            if($isHelpful){
                UserStats::addHelpful($recipe->author_id);
                WeeklyStats::addHelpful($recipe->author_id);
                $review->helpful++;
            }
            else{
                UserStats::addNonHelpful($recipe->author_id);
                WeeklyStats::addNonHelpful($recipe->author_id);
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
