<?php

class AccountController extends BaseController {

    public function index(){

        $user = Auth::user();
        $weekly = WeeklyStats::where('user_id', '=', $user->id)->first();
        $overall = UserStats::where('user_id', '=', $user->id)->first();

        $balance = UserBalance::where('user_id', '=', $user->id)->pluck('amount');

        return View::make('account.index')->with(array(
            'user' => $user,
            'weekly' => $weekly,
            'overall' => $overall,
            'balance' => $balance
        ));
    }

    public function payout(){
        $user = Auth::user();
        $balance = UserBalance::where('user_id', '=', $user->id)->pluck('amount');

        return View::make('account.payout')->with(array(
            'user' => $user,
            'balance' => $balance
        ));
    }

    public function createPayout(){
        $user_id = Auth::id();
        if(PaymentQueue::where('user_id', '=', $user_id)->first()){
            return Redirect::to('account');
        }
        $balance = UserBalance::where('user_id', '=', $user_id)->pluck('amount');
        $paypal_email = Input::get('paypal_email');

        PaymentQueue::add($user_id, $balance, $paypal_email);

        return Redirect::to('account');
    }
}
