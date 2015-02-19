<?php

namespace admin;

use Illuminate\Support\Facades\View;

class AdminController extends \BaseController {

    public function index(){
        return View::make('admin.index');
    }

}
