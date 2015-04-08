<?php

class Recipe extends Eloquent{
    protected $table = 'recipes';
    public static $rules = array(
        'name' => 'required|max:75',
        'description' => 'required',
        'url' => 'url',
        'categorys' => 'required|array',
        'prep_time' => 'required|numeric|max:999',
        'cook_time' => 'required|numeric|max:999',
        'total_time' => 'required|numeric|max:999',
        'servings' => 'required|not_in:0',
        'ingredients' => 'required',
        'directions' => 'required'
        );

    public static function make($input){
        $recipe = new self;
        $recipe->subscriber_count = 0;
        return $recipe->edit($input);
    }

    public function edit($input, $admin = null)
    {
        $this->name = $input['name'];
        $this->slug = str_replace(' ', '-', $input['name']);
        $this->author_id = Auth::id();
        $this->private = $input['private'];
        $this->description = $input['description'];
        $this->category = implode(',',$input['categorys']);
        $this->servings = $input['servings'];
        $this->prep_time = $input['prep_time'] . " " . $input['prep_time_type'];
        $this->cook_time = $input['cook_time'] . " " . $input['cook_time_type'];
        $this->total_time = $input['total_time'] . " " . $input['total_time_type'];
        $this->ingredients = $input['ingredients'];
        $this->directions = $input['directions'];
        $this->url = $input['url'];
        $this->note = $input['note'];


        if (isset($input['recipe_image_values'])){
            $image_data = Image::getFrom64($input['recipe_image_values']);
            $this->image = $this->name . '-' . $this->author_id . '.' . $image_data['extension'];
            Image::store64($image_data['data'], $this->image);
        }
        if($this->image && !isset($input['recipe_image_values']) && !empty($input['recipe_image'])){
            $this->image = '';
        }

        $this->reviewed = 0;

        $this->save();

        return $this;
    }

    public function hasSubscribers(){
        // Does a given recipe_id have subscribers besides the owner
        return $this->subscriber_count > 1;
    }

    public function addSubscriber(){
        $this->subscriber_count += 1;
        $this->save();
    }

    public function removeSubscriber(){
        $this->subscriber_count -= 1;
        $this->save();
    }

    public function updateRating(){
        $this->overall_rating = Review::where('recipe_id', '=', $this->id)->sum('rating') / Review::where('recipe_id', '=', $this->id)->count();
        return $this->save();
    }

    public static function search($search_text, $skip_amount, $sort = null, $category = null){
        $orderBy = 'overall_rating';
        if($sort == 'popularity'){
            $orderBy = 'subscriber_count';
        }
        else if($sort == 'new'){
            $orderBy = 'created_at';
        }

        if($category){
            $recipes = Recipe::where('name', 'LIKE', '%'.$search_text.'%')
                ->where('category', '=', $category)
                ->where(function($query){
                    $query->where('private', '=', 0)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->where(function($query){
                    $query->where('approved', '=', 1)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->orderBy($orderBy, 'desc')
                ->skip($skip_amount)->take(8)->get();
        }
        else{
            $recipes = Recipe::where('name', 'LIKE', '%'.$search_text.'%')
                ->where(function($query){
                    $query->where('private', '=', 0)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->where(function($query){
                    $query->where('approved', '=', 1)
                        ->orWhere('author_id', '=', Auth::id());
                })
                ->orderBy($orderBy, 'desc')
                ->skip($skip_amount)->take(8)->get();
        }

        foreach($recipes as $recipe){
            $recipe->user = User::find($recipe->author_id);
            $recipe->category = Category::find($recipe->category);
            $recipe->review_count = Review::where('recipe_id', '=', $recipe->id)->count();
        }

        return $recipes;
    }

    public function page_view(){
        return $this->increment('page_views');
    }
}
