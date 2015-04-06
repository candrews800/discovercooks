<?php

class ViewHelper
{
    public static function addClass($class, $bool)
    {
        if ($bool) {
            return $class;
        }
        return " ";
    }

    public static function addProfileReview($review){
        $output = '';
        $output.= '<div class="col-xs-12 col-sm-6 col-md-4">';
        $output.=   '<div class="recipe-review clearfix">';
        $output.=       '<a href="'.url('recipe/'.$review->recipe->slug).'"><img class="img-responsive" src="'.url(ViewHelper::getRecipeImage($review->recipe->image)).'" /></a>';

        $output.=       '<div class="upper-menu clearfix">';

        $output.=       '<h1><a href="'.url('recipe/'.$review->recipe->slug).'">'.$review->recipe->name.'</a></h1>';

        $output.=       '<p class="review-helpful">';
        $output.=        $review->helpful .' out of '. $review->total_helpful .' people found this review helpful.';
        $output.=       '</p>';
        $output.=       '<div class="ratings clearfix">'.ViewHelper::addRatingImages($review->rating).'</div>';
        $output.=       '<div class="date">'.$review->created_at->format('M d, Y').'</div>';
        $output.=       '</div>';

        $output.=       '<div class="lower-menu">';

        $output.=       '<p class="review-text">'.nl2br(e($review->text)).'</p>';
        $output.=       '</div>';
        $output.=   '</div>';
        $output.= '</div>';

        return $output;
    }

    public static function addRatingImages($rating_value = 0)
    {
        $output = '';
        for ($i = 0; $i < 5; $i++) {
            if ($rating_value - $i > .88) {
                $output .= '<img src="' . url('assets/img/star-100.png') . '" />';
            } elseif ($rating_value - $i > 0.62) {
                $output .= '<img src="' . url('assets/img/star-75.png') . '" />';
            } elseif ($rating_value - $i > 0.38) {
                $output .= '<img src="' . url('assets/img/star-50.png') . '" />';
            } elseif ($rating_value - $i > 0.12) {
                $output .= '<img src="' . url('assets/img/star-25.png') . '" />';
            } else {
                $output .= '<img src="' . url('assets/img/star-0.png') . '" />';
            }
        }
        return $output;
    }

    public static function addReview($review)
    {
        $output = '';

        $output .= '<div class="review col-xs-12 col-sm-4">';
        $output .= '<a class="review-author" href="'.url('profile/'.$review->author->username).'">' . e($review->author->username) . '</a>';
        $output .= '<div class="ratings">' . ViewHelper::addRatingImages($review->rating) . '</div>';
        $output .= '<p class="review-text">' . nl2br(e($review->text)) . ' <span class="date">' . $review->updated_at->format('M j, Y') . '</span></p>';

        if ($review->helpful === 1 || $review->helpful === 0) {
            $output .= '<i class="helpful-link helpful glyphicon glyphicon-chevron-up';
            if ($review->helpful) {
                $output .= " selected";
            }
            $output .= '" ></i >';

            $output .= '<i class="helpful-link non-helpful glyphicon glyphicon-chevron-down';
            if (!$review->helpful) {
                $output .= " selected";
            }
            $output .= '" ></i >';
        } else {
            $output .= '<i class="helpful-link helpful glyphicon glyphicon-chevron-up"></i >';
            $output .= '<i class="helpful-link non-helpful glyphicon glyphicon-chevron-down"></i >';
        }
        $output .= '</div>';

        return $output;
    }

    public static function addRecipe($recipe, $xs = 12, $sm = 6, $md = 4, $lg = 3){
        $output = '';

        $output.= '<div class="col-xs-'.$xs.' col-sm-'.$sm.' col-md-'.$md.' col-lg-'.$lg.' masonry-item">';
        $output.=     '<div class="search-item clearfix">';
        $output.=         '<a href="'.url('recipe/'.$recipe->slug).'"><div class="crop" style="background-image:url(\''.url(ViewHelper::getRecipeImage($recipe->image)).'\')"></div></a>';
        $output.=         '<div class="upper-menu">';
        $output.=               '<div data-slug="'. $recipe->slug .'" class="subscriber_count';
        $save_text = 'Save';
        if($recipe->isSaved){
            $output.= ' saved';
            $save_text = 'Saved';
        }
        $output.=                                             '">';

        $output.=       '<div class="overall-bg"><i class="heart glyphicon glyphicon-heart"></i></div>';
        $output.=       '<div class="num">'.$recipe->subscriber_count.'</div>';
        $output.=       '<div class="save-button">'.$save_text.'</div>';
        $output.= '</div>';
        $output.=               '<h1><a class="search-item-title" href="'.url('recipe/'.$recipe->slug).'">'.$recipe->name.'</a></h1>';
        $output.=         '</div>';
        $output.=         '<div class="lower-menu clearfix">';

        $desc = substr($recipe->description, 0, 75);
        $output.=               '<p class="search-item-desc">';
        $output.=         $desc;
        if(strlen($recipe->description) > 75){
            $output.= '.. <a href="'.url('recipe/'.$recipe->slug).'">more</a>';
        }
        $output.=         '<div class="search-item-left">';
        $output.=             '<p class="search-item-author"><a href="'.url('profile/'.$recipe->user->username).'">'.$recipe->user->username.'</a></p>';
        $output.=         '</div>';
        $output.=         '<div class="search-item-right">';
        $output.=             '<div class="ratings">';
        $output.=             self::addRatingImages($recipe->overall_rating);
        $output.=             '('.$recipe->review_count.')</div>';
        $output.=         '</div>';
        $output.=         '</div>';
        $output.=         '<div class="divider"></div>';
        $output.=         '<div class="footer-menu clearfix">';
        $output.=             '<p><i class="glyphicon glyphicon-time"></i> Total: <span>'.$recipe->total_time.'</span></p>';
        $output.=         '</div>';
        $output.=     '</div>';
        $output.=  '</div>';

        return $output;
    }

    public static function addUser($user){
        $output = '';

        $output.= '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-2 masonry-item">';
        $output.=     '<div class="search-item clearfix">';
        $output.=         '<a class="search-item-title" href="'.url('profile/'.$user->username).'"><img id="search-user-image" class="search-item-image" src="'.url(ViewHelper::getUserImage($user->image)).'" /></a>';
        $output.=         '<div class="upper-menu">';
        $output.=         '<h1><a class="search-item-title" href="'.url('profile/'.$user->username).'">'.$user->username.'</a></h1>';
        $output.=         '</div>';

        $output.=         '<div class="lower-menu clearfix">';
        $output.=         '<div class="search-item-left">';
        $output.=             '<p><strong>'.$user->recipe_count.' recipes</strong></p>';
        $output.=         '</div>';
        $output.=         '<div class="search-item-right">';
        $output.=         '</div>';
        $output.=         '</div>';
        $output.=     '</div>';
        $output.=  '</div>';

        return $output;
    }

    public static function getRecipeImage($food_image){
        if($food_image){
            return 'recipe_images/'.$food_image;
        }
        else{
            return 'assets/img/recipe-image.png';
        }
    }

    public static function getUserImage($user_image){
        if($user_image){
            return 'user_images/'.$user_image;
        }
        else{
            return 'assets/img/user-image.png';
        }
    }

    public static function getBreadcrumbs($parents, $child, $dark_bg = null){
        $response = '';
        $response .= '<div class="row">';
        $response .= '<div class="col-xs-12">';
        $response .= '<div id="breadcrumbs"';
        if($dark_bg){
            $response .= ' class="dark-bg"';
        }
        $response .=                        '>';
        $response .= '<div class="home">';
        $response .= '<a href="'.url('/').'">Home</a>';
        $response .= '</div>';
        $response .= '<div class="breadcrumb-divider"><i class="glyphicon glyphicon-menu-right"></i></div>';

        if($parents != null){
            foreach($parents as $parent){
                $response .= '<div class="parent">';
                $response .= '<a href="'.$parent['url'].'">'.$parent['text'].'</a>';
                $response .= '</div>';
                $response .= '<div class="breadcrumb-divider"><i class="glyphicon glyphicon-menu-right"></i></div>';
            }
        }

        $response .= '<div class="self">';
        $response .= $child;
        $response .= '</div>';
        $response .= '</div>';
        $response .= '</div>';
        $response .= '</div>';

        return $response;
    }

    public static function getNewBreadcrumbs($parents, $child){
        $response = '';
        $response .= '<ol class="breadcrumb">';
        $response .= '<li><a href="'.url().'">Home</a></li>';

        if($parents != null){
            foreach($parents as $parent){
                $response .= '<li><a href="'.$parent['url'].'">'.$parent['text'].'</a></li>';
            }
        }

        $response .= '<li class="active">'.$child.'</li>';
        $response .= '</ol>';

        return $response;
    }

    public static function tileRecipes($recipes, $x = 144, $y = 81)
    {
        if($recipes->isEmpty()){
            return '';
        }

        $response = 'style="background:';

        $offset = $x/2;

        $row = 0;
        $col = 0;
        $key_offset = 0;

        while ($row < 50){
            foreach ($recipes as $key => $recipe) {
                $response .= 'url(\'' . url(self::getRecipeImage($recipe->image)) . '\') no-repeat ' . (($col  - $key_offset) * $x - $offset) . 'px ' . $row * $y . 'px,';
                $col++;
                if ($col - $key_offset > 17) {
                    $col = 0;
                    $row++;
                    $key_offset++;
                }
            }
        }

        $response = rtrim($response, ",");
        $response .= '"';

        return $response;
    }

    public static function getProfileHeader($user, $recipe_stats, $review_stats){

    }
}