<?php

class PaymentQueue extends Eloquent{
    protected $table = 'payment_queue';

    public static function add($user_id, $amount, $paypal_email){
        $payment = new self;
        $payment->user_id = $user_id;
        $payment->amount = $amount;
        $payment->paypal_email = $paypal_email;
        $payment->save();
    }
}
