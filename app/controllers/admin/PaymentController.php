<?php

namespace admin;

use Illuminate\Support\Facades\View;

class PaymentController extends \BaseController {

    public function siteBalances(){
        $site_balance = \UserBalance::where('user_id', '=', 0)->first();

        return View::make('admin.payments.site_balances')->with(array(
            'site_balance' => $site_balance
        ));
    }

    public function creditAccounts(){

        return View::make('admin.payments.credit_acounts')->with(array(

        ));
    }

    public function doCreditAccounts(){
        $input = \Input::all();
        $revenue = $input['revenue'];
        $page_views = $input['page_views'];
        $recipe_percent = $input['recipe_percent'];
        $review_percent = $input['review_percent'];

        $weekly_nethelpful = \WeeklyStats::sum('review_helpful') - \WeeklyStats::sum('review_nonhelpful');
        if(!$weekly_nethelpful){
            $weekly_nethelpful = 1;
        }

        $weekly_stats = \WeeklyStats::all();
        foreach($weekly_stats as $stat){
            // Credit for Recipe Views
            $amt = $revenue * ($recipe_percent/100) * ($stat->page_views / $page_views);
            if($amt > 0){
                \Transaction::creditUser($stat->user_id, round($amt, 2), 'Recipe Views Credit');
                \Transaction::debitSite(round($amt, 2), $stat->user_id, 'Recipe Views Credit');
            }

            // Credit for Reviews
            $amt = $revenue * ($review_percent*100) * (($stat->helpful - $stat->nonhelpful) / $weekly_nethelpful);
            if($amt > 0){
                \Transaction::creditUser($stat->user_id, round($amt, 2), 'Helpful Review Credit');
                \Transaction::debitSite(round($amt, 2), $stat->user_id, 'Helpful Review Credit');
            }

            $stat->archive();
        }

        return \Redirect::back();
    }

    public function paymentQueue(){
        $queue = \PaymentQueue::all();

        foreach($queue as $item){
            $item->user = \User::find($item->user_id);
        }

        return View::make('admin.payments.payment_queue')->with(array(
            'queue' => $queue
        ));
    }

    public function processQueueItem($queue_id){
        $queue = \PaymentQueue::find($queue_id);

        \Transaction::withdraw($queue->user_id, round($queue->amount, 2), 'Sent to Paypal');

        $queue->delete();
        return \Redirect::back();
    }
}
