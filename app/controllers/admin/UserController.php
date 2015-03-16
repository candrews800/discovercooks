<?php

namespace admin;

use Illuminate\Support\Facades\View;

class UserController extends \BaseController {


    public function index(){
        $users = \User::paginate(25);

        foreach($users as $user){
            $user->recipe_count = \Recipe::where('author_id', '=', $user->id)->count();
            $user->review_count = \Review::where('reviewer_id', '=', $user->id)->count();
            $user->balance = \UserBalance::where('user_id', '=', $user->id)->pluck('amount');
        }

        return View::make('admin.user.index')->with(array(
            'users' => $users
        ));
    }

    public function redirectSearch($search_text = null){
        if(\Input::has('search_text')){
            $search_text = \Input::get('search_text');
            return \Redirect::to('admin/users/search/'.$search_text);
        }
        return \Redirect::to('admin/users');

    }

    public function search($search_text = null){
        if(\Input::has('search_text')){
            $search_text = \Input::get('search_text');
        }
        if(!$search_text){
            return \Redirect::to('admin/users');
        }

        $users = \User::where('username', 'LIKE', '%'.$search_text.'%')->orWhere('email', 'LIKE', '%'.$search_text.'%')->paginate(25);
        foreach($users as $user){
            $user->recipe_count = \Recipe::where('author_id', '=', $user->id)->count();
            $user->review_count = \Review::where('reviewer_id', '=', $user->id)->count();
        }

        return View::make('admin.user.index')->with(array(
            'search_text' => $search_text,
            'users' => $users
        ));
    }

    public function show(\User $user){


        return View::make('.admin.user.single')->with(array(
            'user' => $user
        ));
    }

    public function edit(\User $user){

        $input = \Input::all();
        $rules = array(
            'username' =>   'required|min:3|unique:users,username,'.$user->id,
            'email'    =>   'required|email|unique:users,email,'.$user->id,
            'facebook' => 'url|regex:/^(http(s)?:\/\/)?(www.)?facebook.com\/(.)+$/',
            'twitter' => 'url|regex:/^(http(s)?:\/\/)?(www.)?twitter.com\/(.)+$/',
            'pinterest' => 'url|regex:/^(http(s)?:\/\/)?(www.)?pinterest.com\/(.)+$/',
            'website' => 'url'
        );

        $validator = \Validator::make($input, $rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $user->edit($input);

        return \Redirect::back();
    }

    public function delete(\User $user){
        $user->delete();

        return \Redirect::back();
    }
}
