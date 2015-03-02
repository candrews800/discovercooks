<?php

namespace forum;

use Illuminate\Support\Facades\View;

class ForumController extends \BaseController {

    public function index(){
        $categorys = \ForumCategory::orderBy('order_id', 'asc')->get();
        $topics = \ForumTopic::orderBy('order_id', 'asc')->get();

        return View::make('forum.index')->with(array(
            'categorys' => $categorys,
            'topics' => $topics
        ));
    }
}
