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

        $weekly_stats = \WeeklyStats::all();
        $total_tickets = \WeeklyStats::sum('tickets');
        $total_page_views = \WeeklyStats::sum('page_views');
        foreach($weekly_stats as $stat){
            // Credit for Tickets
            $amt = $revenue * 0.4 * ($stat->tickets / $total_tickets);
            if($amt > 0){
                \Transaction::creditUser($stat->user_id, round($amt, 2), 'Content Creation Credit');
                \Transaction::debitSite(round($amt, 2), $stat->user_id, 'Content Creation Credit');
            }

            // Credit for Page Views
            $amt = $revenue * 0.4 * ($stat->page_views / $total_page_views);
            if($amt > 0){
                \Transaction::creditUser($stat->user_id, round($amt, 2), 'Recipe Performance Credit');
                \Transaction::debitSite(round($amt, 2), $stat->user_id, 'Recipe Performance Credit');
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
