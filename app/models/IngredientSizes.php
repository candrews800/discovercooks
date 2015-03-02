<?php

class IngredientSizes extends Eloquent{
    protected $table = 'ingredient_sizes';
    public $timestamps = false;

    public static function getAll(){
        $sizes =  self::orderBy('name', 'asc')->get();

        $ingredient_sizes = [];
        foreach($sizes as $size){
            $ingredient_sizes[$size->name] = $size->name;
        }

        return $ingredient_sizes;
    }
}
