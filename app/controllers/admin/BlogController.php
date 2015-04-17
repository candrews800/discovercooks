<?php

namespace admin;

use Illuminate\Support\Facades\View;

class BlogController extends \BaseController {

    public function home(){

        $posts = \BlogPost::all();

        return View::make('admin.blog.index')->with(array(
            'posts' => $posts
        ));
    }

    public function showPost($blog_id){
        $post = \BlogPost::find($blog_id);

        return View::make('admin.blog.post')->with(array(
            'post' => $post
        ));
    }

    public function editPost($blog_id){
        $post = \BlogPost::find($blog_id);

        $input = \Input::all();

        $post->slug = $input['slug'];
        $post->title = $input['title'];
        $post->text = $input['text'];
        $post->save();


        return \Redirect::back();
    }

    public function showCreate(){

        return View::make('admin.blog.create')->with(array(

        ));
    }

    public function create(){
        $input = \Input::all();

        $blog_post = new \BlogPost();
        $blog_post->slug = $input['slug'];
        $blog_post->title = $input['title'];
        $blog_post->text = $input['text'];
        $blog_post->author_id = \Auth::id();
        $blog_post->save();

        return \Redirect::to('admin/blog');
    }
}
