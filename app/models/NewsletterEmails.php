<?php

class NewsletterEmails extends Eloquent{
    protected $table = 'newsletter_emails';
    public $timestamps = false;

    public static function add($email){
        $signup = self::where('email', '=', $email)->first();
        if($signup){
            return false;
        }
        $signup = new self;
        $signup->email = $email;
        $signup->save();
        return true;
    }

    public static function remove($email){
        return self::where('email', '=', $email)->delete();
    }
}
