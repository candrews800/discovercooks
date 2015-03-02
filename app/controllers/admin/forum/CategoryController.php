<?php

namespace admin\forum;

use Illuminate\Support\Facades\View;

class CategoryController extends \BaseController {

    public function all(){
        $categorys = \ForumCategory::orderBy('order_id', 'asc')->get();
        return View::make('admin.forum.category.all')->with(array(
            'categorys' => $categorys
        ));
    }

    public function create(){
        $category = new \ForumCategory;
        $category->name = \Input::get('category_name');
        $category->order_id = \ForumCategory::max('order_id') + 1;
        $category->save();

        return \Redirect::back();
    }

    public function edit($category_id){
        $category = \ForumCategory::find($category_id);
        $category->name = \Input::get('category_name');
        $category->save();

        return \Redirect::back();
    }

    public function delete($category_id){
        $category = \ForumCategory::find($category_id);
        $category->delete();
        \ForumCategory::where('order_id', '>', $category->id)->decrement('order_id');

        return \Redirect::back();
    }

    public function updatePositions(){
        $orderBy = \Input::get('orderBy');
        $orderBy = rtrim($orderBy, ",");
        $categorys = explode(',', $orderBy);
        foreach($categorys as $key=>$category_id){
            $category = \ForumCategory::find($category_id);
            $category->order_id = $key + 1;
            $category->save();
        }
    }
}
