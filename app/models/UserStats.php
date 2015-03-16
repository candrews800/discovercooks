<?php

class UserStats extends Eloquent{
    protected $table = 'user_stats';
    public $timestamps = false;

    public static function getStats($user_id){
        $stats = self::where('user_id', '=', $user_id)->first();
        if(!$stats){
            $stats = new self;
            $stats->user_id = $user_id;
            $stats->save();
        }

        return $stats;
    }

    public static function page_view($user_id){
        $stats = self::getStats($user_id);
        return $stats->increment('page_views');
    }

    public static function addHelpful($user_id){
        $stats = self::getStats($user_id);
        return $stats->increment('review_helpful');
    }

    public static function removeHelpful($user_id){
        $stats = self::getStats($user_id);
        return $stats->decrement('review_helpful');
    }

    public static function addNonHelpful($user_id){
        $stats = self::getStats($user_id);
        return $stats->increment('review_nonhelpful');
    }

    public static function removeNonHelpful($user_id){
        $stats = self::getStats($user_id);
        return $stats->decrement('review_nonhelpful');
    }

    public static function addRecipe($user_id){
        $stats = self::getStats($user_id);
        return $stats->increment('total_recipes');
    }

    public static function addReview($reviewer_id){
        $stats = self::getStats($reviewer_id);
        return $stats->increment('total_reviews');
    }
}
