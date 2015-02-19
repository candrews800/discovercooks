<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements ConfideUserInterface{

    use ConfideUser;
    use HasRole;

	protected $table = 'users';

	protected $hidden = array('password', 'remember_token');

    public function edit($input){

        $this->username = $input['username'];
        $this->email = $input['email'];
        $this->hometown = $input['hometown'];
        $this->location = $input['location'];
        $this->hobbies = $input['hobbies'];
        $this->facebook = $input['facebook'];
        $this->twitter = $input['twitter'];
        $this->pinterest = $input['pinterest'];
        $this->website = $input['website'];



        if (isset($input['image_values'])){
            $image_data = Image::getFrom64($input['image_values']);
            $this->image = $this->username . '.' . $image_data['extension'];
            Image::store64($image_data['data'], $this->image, 'user_images');
        }

        $this->save();

        return $this;
    }

    public function hasRecipe($recipe_id){
        $recipe_list = $this->subscribed_recipes;

        return preg_match('/\b'.$recipe_id.'\b/', $recipe_list);
    }

    public function addRecipe($recipe_id){
        if($this->hasRecipe($recipe_id)){
            return false;
        }
        else{
            $this->subscribed_recipes .= ' ' . $recipe_id;
            $this->subscribed_recipes = trim($this->subscribed_recipes);
            $this->save();

            return true;
        }
    }

    public function removeRecipe($recipe_id){
        if( ! $this->hasRecipe($recipe_id)){
            return false;
        }
        else{
            $this->subscribed_recipes = preg_replace('/\b'.$recipe_id.'\b/', ' ', $this->subscribed_recipes);
            $this->subscribed_recipes = preg_replace('/\\s\\s+/', ' ', $this->subscribed_recipes);
            $this->subscribed_recipes = trim($this->subscribed_recipes);
            $this->save();

            return true;
        }
    }
}
