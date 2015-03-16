<?php

class SiteStats extends Eloquent{
    protected $table = 'site_stats';
    public $timestamps = false;

    public static function page_view(){
        $stats = self::find(1);
        return $stats->increment('page_views');
    }

    public static function addRecipe(){
        $stats = self::find(1);
        return $stats->increment('total_recipes');
    }

    public static function addReview(){
        $stats = self::find(1);
        return $stats->increment('total_reviews');
    }
}
