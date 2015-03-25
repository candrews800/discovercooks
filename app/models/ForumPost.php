<?php

class ForumPost extends Eloquent{
    protected $table = 'forum_posts';

    public function forum_replys(){
        return $this->hasMany('ForumReply', 'post_id');
    }

    public function getDates()
    {
        return ['created_at', 'updated_at', 'last_activity'];
    }

    public static function make($input, $topic_id, $author_id){
        $post = new self;
        $post->topic_id = $topic_id;
        $post->author_id = $author_id;
        $post->view_count = 1;
        $post->last_activity = time();
        return $post->edit($input);
    }

    public function edit($input){
        $this->title = $input['title'];
        $this->text = $input['text'];
        if($this->save()){
            return $this;
        }
        return false;
    }

    public function addView(){
        $this->view_count += 1;
        $this->timestamps = false;
        $this->save();
    }

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

    public function lastActivity(){
        $min = $this->last_activity->diffInMinutes();
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

        return $this->last_activity->format('m/d/y');
    }

    public function touchLastActivity(){
        $this->last_activity = time();
        $this->timestamps = false;
        $this->save();
    }
}
