<?php

namespace forum;

use Illuminate\Support\Facades\View;

class ReplyController extends \BaseController {

    public function create(\ForumPost $post){
        $input = \Input::all();

        \ForumReply::make($input, $post->id, \Auth::id());
        \ForumUserStats::addPost(\Auth::id());

        return \Redirect::back();
    }

    public function show(\ForumReply $reply){
        if($reply->author_id != \Auth::id()){
            return Redirect::back();
        }
        $reply->author = \User::find($reply->author_id);
        $post = \ForumPost::find($reply->post_id);
        $topic = \ForumTopic::find($post->topic_id);

        return View::make('forum.reply')->with(array(
            'reply' => $reply,
            'post' => $post,
            'topic' => $topic
        ));
    }

    public function edit(\ForumReply $reply){
        $reply->text = \Input::get('text');
        $reply->save();

        $post = \ForumPost::find($reply->post_id);

        return \Redirect::to('forum/post/'.$post->id);
    }

    public function delete(\ForumReply $reply){
        $reply->delete();

        return \Redirect::back();
    }
}
