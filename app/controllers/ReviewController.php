<?php

class ReviewController extends BaseController {

    public function add(Recipe $recipe){
        $input = Input::all();
        $input['recipe_id'] = $recipe->id;

        Review::add($input);
        $recipe->updateRating();

        return Redirect::back();
    }

    public function loadReviews($recipe, $skip_amount, $amount = 6){
        $reviews = Review::where('recipe_id', '=', $recipe->id)->skip($skip_amount)->take($amount)->get();

        if(!$reviews->isEmpty()) {
            $output = '';
            foreach ($reviews as $key=>$review) {
                if ($key % 3 == 0) {
                    $output .= '<div class="clearfix" >';
                }
                $review->author = User::find($review->reviewer_id);

                if (Auth::id()) {
                    $helpful = HelpfulReview::where('recipe_id', '=', $recipe->id)
                        ->where('review_id', '=', $review->id)
                        ->where('user_id', '=', Auth::id())->first();
                    if ($helpful) {
                        $review->helpful = $helpful->isHelpful;
                    } else {
                        $review->helpful = '';
                    }
                }
                $output .= ViewHelper::addReview($review);

                if (($key % 3 == 0 && $key > 0) || $key == sizeof($reviews) - 1){
                    $output .= '</div>';
                }
            }
            return $output;
        }

        return 0;
    }
}