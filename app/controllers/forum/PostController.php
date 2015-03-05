<?php

namespace forum;

use Illuminate\Support\Facades\View;

class PostController extends \BaseController {

    public function create(\ForumTopic $topic){
        $input = \Input::all();

        $post = \ForumPost::make($input, $topic->id, \Auth::id());
        \ForumUserStats::addPost(\Auth::id());

        return \Redirect::to('forum/'.str_replace(' ', '-', $topic->name).'/'.$post->id);
    }

    public function showCreate(\ForumTopic $topic){

        return View::make('forum.postCreate')->with(array(
            'topic' => $topic
        ));
    }

    public function show(\ForumTopic $topic, \ForumPost $post){
        $post->addView();

        $post->author = \User::find($post->author_id);
        $post->author->post_count = \ForumUserStats::getPostCount($post->author->id);

        $replys = \ForumReply::where('post_id', $post->id)->orderBy('created_at', 'asc')->paginate(20);
        foreach($replys as $key => $reply){
            $reply->author = \User::find($reply->author_id);
            $reply->author->post_count = \ForumUserStats::getPostCount($reply->author->id);
            $page = \Input::get('page');
            $reply->num = $key + 2;
            if($page > 1){
                $reply->num = ($page-1)*20 + $key;
            }
        }


        return View::make('forum.post')->with(array(
            'topic' => $topic,
            'post' => $post,
            'replys' => $replys
        ));
    }

    public function showEdit(\ForumTopic $topic, \ForumPost $post){
        $post->addView();

        $post->author = \User::find($post->author_id);

        $replys = \ForumReply::where('post_id', $post->id)->get();
        foreach($replys as $reply){
            $reply->author = \User::find($reply->author_id);
        }


        return View::make('forum.postEdit')->with(array(
            'topic' => $topic,
            'post' => $post,
            'replys' => $replys
        ));
    }

    public function edit(\ForumTopic $topic, \ForumPost $post){
        $input = \Input::all();

        $post->edit($input);

        return \Redirect::to('forum/'.str_replace(' ', '-', $topic->name).'/'.$post->id);
    }

    public function delete(\ForumTopic $topic, \ForumPost $post){
        $post->delete();

        return \Redirect::to('forum/'.str_replace(' ', '-', $topic->name));
    }

    public function addSticky(\ForumTopic $topic, \ForumPost $post){
        $post->sticky = 1;
        $post->save();

        return \Redirect::back();
    }

    public function removeSticky(\ForumTopic $topic, \ForumPost $post){
        $post->sticky = 0;
        $post->save();

        return \Redirect::back();
    }
}
