<?php

use Zizaco\Confide\UserValidator;

class CustomUserValidator extends UserValidator
{
    public $rules = [
        'create' => [
            'username' => 'required|alpha_dash|min:3|max:24',
            'email'    => 'required|email|min:5|max:100',
            'password' => 'required|min:6',
        ],
        'update' => [
            'username' => 'required|alpha_dash|min:3|max:24',
            'email'    => 'required|email|min:5|max:100',
            'password' => 'required|min:6',
        ]
    ];
}