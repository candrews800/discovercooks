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

    public function archive(){
        $start_date = WeeklyStatsArchive::where('user_id', '=', $this->user_id)->max('end');
        if(!$start_date){
            $date = \User::find($this->user_id);
            $start_date = $date->created_at->format('Y-m-d');
        }
        $archive = new WeeklyStatsArchive();
        $archive->user_id = $this->user_id;
        $archive->page_views = $this->page_views;
        $archive->review_helpful = $this->review_helpful;
        $archive->review_nonhelpful = $this->review_nonhelpful;
        $archive->start = $start_date;
        $archive->end = date('Y-m-d');
        if($archive->save()){
            $this->page_views = 0;
            $this->review_helpful = 0;
            $this->review_nonhelpful = 0;
            $this->save();
        }
        return false;
    }
}
