<?php

namespace admin;

use Illuminate\Support\Facades\View;

class NewsletterController extends \BaseController {


    public function index(){
        $newsletter_emails = \NewsletterEmails::all();

        return View::make('admin.newsletter')->with(array(
            'newsletter_emails' => $newsletter_emails
        ));
    }
}
