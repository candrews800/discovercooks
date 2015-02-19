<?php

class Category extends Eloquent{
    protected $table = 'categorys';
    public $timestamps = false;

    public static function getSelectList(){
        $selectList = [];
        $categories = self::all();

        $selectList[0] = '- Select Category -';
        foreach($categories as $category){
            $selectList[$category->id] = $category->name;
        }

        return $selectList;
    }
}
