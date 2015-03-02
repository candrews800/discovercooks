<?php

class ForumReply extends Eloquent{
    protected $table = 'forum_replys';

    public static function make($input, $post_id, $author_id){
        $reply = new self;
        $reply->post_id = $post_id;
        $reply->author_id = $author_id;

        // Touch Last Activity On Post
        \ForumPost::find($post_id)->touchLastActivity();
        return $reply->edit($input);
    }

    public function edit($input){
        $this->text = $input['text'];
        if($this->save()){
            return $this;
        }
        return false;
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
}
