<?php

class BlogComment extends Eloquent{
    protected $table = 'blog_comments';

    public function shortDate(){
        $min = $this->created_at->diffInMinutes();
        if($min < 1){
            return '<1m';
        }
        if($min < 60){
            return $min.'m';
        }
        $hr = floor($min/60);
        if($hr < 24){
            return $hr.'h, '.($min - $hr*60).'m';
        }
        $day = floor($hr / 24);
        if($day < 28){
            return $day.'d, '.($hr - $day*24).'h';
        }

        return $this->created_at->format('m/d/y');
    }
}
