<?php

class Transaction extends Eloquent{
    protected $table = 'transactions';

    public static function creditUser($user_id, $amount, $description){
        $transaction = new self;
        $transaction->user_id = $user_id;
        $transaction->amount = $amount;
        $transaction->type = 'c';
        $transaction->initiator = 'Site Payments';
        $transaction->description = $description;

        if($transaction->save()){
            UserBalance::credit($user_id, $amount);
        }
    }

    public static function withdraw($user_id, $amount, $description){
        $transaction = new self;
        $transaction->user_id = 'Withdraw';
        $transaction->amount = $amount;
        $transaction->type = 'd';
        $transaction->initiator = $user_id;
        $transaction->description = $description;

        if($transaction->save()){
            UserBalance::debit($user_id, $amount);
        }
    }

    public static function creditSite($amount, $description){
        $transaction = new self;
        $transaction->user_id = 0;
        $transaction->amount = $amount;
        $transaction->type = 'c';
        $transaction->initiator = 'External Account';
        $transaction->description = $description;

        if($transaction->save()){
            UserBalance::creditSite($amount);
        }
    }

    public static function debitSite($amount, $to, $description){
        $transaction = new self;
        $transaction->user_id = 0;
        $transaction->amount = $amount;
        $transaction->type = 'd';
        $transaction->initiator = 'Site Payments';
        $transaction->description = $description . ' - ' . $to;

        if($transaction->save()){
            UserBalance::debitSite($amount);
        }
    }
}
