<?php

namespace forum;

use Illuminate\Support\Facades\View;

class ForumController extends \BaseController {

    public function index(){
        $categorys = \ForumCategory::all();
        $topics = \ForumTopic::all();

        return View::make('forum.index')->with(array(
            'categorys' => $categorys,
            'topics' => $topics
        ));
    }
}
