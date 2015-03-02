<?php

class ForumUserStats extends Eloquent{
    protected $table = 'forum_user_stats';
    public $timestamps = false;

    public static function addPost($user_id){
        $user_stats = self::where('user_id', $user_id)->first();
        if(!$user_stats){
            $user_stats = new self;
            $user_stats->user_id = $user_id;
            $user_stats->post_count = 0;
        }
        $user_stats->post_count++;
        $user_stats->save();
    }

    public static function removePost($user_id){
        $user_stats = self::where('user_id', $user_id)->first();
        $user_stats->post_count--;
        $user_stats->save();
    }

    public static function getPostCount($user_id){
        $user_stats = self::where('user_id', $user_id)->first();
        if(!$user_stats){
            return 0;
        }
        return $user_stats->post_count;
    }
}
