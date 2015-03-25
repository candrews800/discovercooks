<?php

namespace forum;

use Illuminate\Support\Facades\View;

class ForumController extends \BaseController {

    public function index(){
        $categorys = \ForumCategory::orderBy('order_id', 'asc')->get();
        $topics = \ForumTopic::orderBy('order_id', 'asc')->get();

        foreach($topics as $topic){
            $topic->total_posts = \ForumPost::where('topic_id', '=', $topic->id)->count();
            $topic->total_replys = \ForumReply::join('forum_posts', 'forum_replys.post_id', '=', 'forum_posts.id')->where('topic_id', '=', $topic->id)->count();

            $topic->last_activity = \ForumPost::where('topic_id', '=', $topic->id)->orderBy('last_activity', 'desc')->first();
            if($topic->last_activity){
                $topic->last_activity->author = \User::find($topic->last_activity->author_id);
            }
        }

        return View::make('forum.index')->with(array(
            'categorys' => $categorys,
            'topics' => $topics
        ));
    }
}
