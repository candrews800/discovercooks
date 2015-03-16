<?php

namespace admin;

use Illuminate\Support\Facades\View;

class StatsController extends \BaseController {

    public function overall(){

        $stats = \SiteStats::find(1);

        $recipe_page_views = \Recipe::sum('page_views');

        $helpful = \Review::sum('helpful');
        $nonhelpful = \Review::sum('non_helpful');

        $weekly_recipe_page_views = \WeeklyStats::sum('page_views');
        $weekly_helpful = \WeeklyStats::sum('review_helpful');
        $weekly_nonhelpful = \WeeklyStats::sum('review_nonhelpful');


        return View::make('admin.stats.overall')->with(array(
            'stats' => $stats,
            'recipe_page_views' => $recipe_page_views,
            'helpful' => $helpful,
            'nonhelpful' => $nonhelpful,
            'weekly_recipe_page_views' => $weekly_recipe_page_views,
            'weekly_helpful' => $weekly_helpful,
            'weekly_nonhelpful' => $weekly_nonhelpful
        ));
    }

    public function users(){

        $stats = \UserStats::paginate(25);
        foreach($stats as $stat){
            $stat->user = \User::find($stat->user_id);
            $stat->weekly = \WeeklyStats::where('user_id', '=', $stat->user_id)->first();
        }


        return View::make('admin.stats.users')->with(array(
            'stats' => $stats
        ));
    }

    public function recipes(){
        $recipes = \Recipe::paginate(25);

        return View::make('admin.stats.recipes')->with(array(
            'recipes' => $recipes
        ));
    }

    public function reviews(){
        $reviews = \Review::paginate(25);

        return View::make('admin.stats.reviews')->with(array(
            'reviews' => $reviews
        ));
    }
}
