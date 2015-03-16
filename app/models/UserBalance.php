<?php

class UserBalance extends Eloquent{
    protected $table = 'user_balances';
    public $timestamps = false;

    public static function make($user_id){
        $balance = new self;
        $balance->user_id = $user_id;
        $balance->amount = 0;
        $balance->save();
    }

    public static function credit($user_id, $amount){
        $balance = self::where('user_id', '=', $user_id)->first();
        $balance->amount += $amount;
        return $balance->save();
    }

    public static function debit($user_id, $amount){
        $balance = self::where('user_id', '=', $user_id)->first();
        $balance->amount -= $amount;
        return $balance->save();
    }

    public static function creditSite($amount){
        $balance = self::where('user_id', '=', 0)->first();
        $balance->amount += $amount;
        return $balance->save();
    }

    public static function debitSite($amount){
        $balance = self::where('user_id', '=', 0)->first();
        $balance->amount -= $amount;
        return $balance->save();
    }
}
