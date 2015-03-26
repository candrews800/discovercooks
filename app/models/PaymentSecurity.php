<?php

class PaymentSecurity extends Eloquent{
    protected $table = 'payment_security';
    public $timestamps = false;

    public static function make($input, User $user){
        $security = new self;
        $security->user_id = $user->id;
        $security->security_question = $input['question'];
        $security->security_answer = Hash::make(strtolower($input['answer']));
        return $security->save();
    }
}
