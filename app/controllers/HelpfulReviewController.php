<?php

class HelpfulReviewController extends BaseController {

    public function add(Recipe $recipe, $username, $isHelpful){
        $author = User::where('username', '=', $username)->first();
        $review = Review::where('recipe_id', '=', $recipe->id)
                        ->where('reviewer_id', '=', $author->id)->first();

        $helpful = HelpfulReview::where('recipe_id', '=', $recipe->id)
                                ->where('review_id', '=', $review->id)
                                ->where('user_id', '=', Auth::id())->first();
        if(!$helpful){
            $helpful = new HelpfulReview;
        }

        if($helpful->make($recipe, $review, $isHelpful)){
            return 1;
        }
        return 0;
    }
}
