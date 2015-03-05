<?php

namespace forum;

use Illuminate\Support\Facades\View;

class TopicController extends \BaseController {

    public function show(\ForumTopic $topic){
        $posts = \ForumPost::where('topic_id', '=', $topic->id)->orderBy('sticky', 'desc')->orderBy('last_activity', 'desc')->paginate(25);

        foreach($posts as $post){
            $post->author = \User::find($post->author_id);
            $post->activity = \ForumReply::where('post_id', '=', $post->id)->orderBy('created_at', 'desc')->first();
            if($post->activity){
                $post->activity->author = \User::find($post->activity->author_id);
            }
            $post->reply_count = \ForumReply::where('post_id', '=', $post->id)->count();
        }

        return View::make('forum.topic')->with(array(
            'topic' => $topic,
            'posts' => $posts
        ));
    }
}
