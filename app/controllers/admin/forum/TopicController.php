<?php

namespace admin\forum;

use Illuminate\Support\Facades\View;

class TopicController extends \BaseController {

    public function all(){
        $topics = \ForumTopic::orderBy('order_id', 'asc')->get();
        $categorys = \ForumCategory::all();
        return View::make('admin.forum.topic.all')->with(array(
            'topics' => $topics,
            'categorys' => $categorys
        ));
    }

    public function create(){
        $topic = new \ForumTopic;
        $topic->name = \Input::get('topic_name');
        $topic->order_id = \ForumTopic::max('order_id') + 1;
        $topic->save();

        return \Redirect::back();
    }

    public function edit($topic_id){
        $topic = \ForumTopic::find($topic_id);
        $topic->name = \Input::get('topic_name');
        $topic->save();

        return \Redirect::back();
    }

    public function delete($topic_id){
        $topic = \ForumTopic::find($topic_id);
        $topic->delete();
        \ForumTopic::where('order_id', '>', $topic->id)->decrement('order_id');

        return \Redirect::back();
    }

    public function updatePositions(){
        $orderBy = \Input::get('orderBy');
        $orderBy = rtrim($orderBy, ",");
        $topics = explode(',', $orderBy);
        foreach($topics as $key=>$topic_id){
            $topic = \ForumTopic::find($topic_id);
            $topic->order_id = $key + 1;
            $topic->save();
        }
    }

    public function editDescription($topic_id){
        $topic = \ForumTopic::find($topic_id);
        $topic->description = \Input::get('description');
        $topic->save();

        return \Redirect::back();
    }

    public function updateCategory($topic_id){
        $topic = \ForumTopic::find($topic_id);
        $topic->category_id = \Input::get('category_id');
        $topic->save();

        return \Redirect::back();
    }
}
