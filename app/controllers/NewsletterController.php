<?php

class NewsletterController extends BaseController {

    public function add(){
        $email = Input::get('email');

        if(NewsletterEmails::add($email)){
            Session::put('newsletter_signup_success', $email);
        }

        return Redirect::back();
    }
}
