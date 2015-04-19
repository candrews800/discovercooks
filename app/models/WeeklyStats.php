<?php

class WeeklyStats extends Eloquent{
    protected $table = 'weekly_stats';
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

    public static function addRecipe($user_id){
        $stats = self::getStats($user_id);
        $stats->increment('tickets', 15);
        return $stats->increment('total_recipes');
    }

    public static function addReview($reviewer_id){
        $stats = self::getStats($reviewer_id);
        $stats->increment('tickets', 1);
        return $stats->increment('total_reviews');
    }

    public static function addReviewImage($reviewer_id){
        $stats = self::getStats($reviewer_id);
        $stats->increment('tickets', 2);
        return $stats->increment('review_with_image');
    }

    public function archive(){
        $start_date = WeeklyStatsArchive::where('user_id', '=', $this->user_id)->max('end');
        if(!$start_date){
            $date = \User::find($this->user_id);
            $start_date = $date->created_at->format('Y-m-d');
        }
        $archive = new WeeklyStatsArchive();
        $archive->user_id = $this->user_id;
        $archive->page_views = $this->page_views;
        $archive->total_recipes = $this->total_recipes;
        $archive->total_reviews = $this->total_reviews;
        $archive->tickets = $this->tickets;
        $archive->review_with_image = $this->review_with_image;
        $archive->start = $start_date;
        $archive->end = date('Y-m-d');
        if($archive->save()){
            $this->page_views = 0;
            $this->total_recipes = 0;
            $this->total_reviews = 0;
            $archive->tickets = 0;
            $archive->review_with_image = 0;

            $this->save();
        }
        return false;
    }
}
