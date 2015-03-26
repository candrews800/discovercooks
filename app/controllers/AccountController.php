<?php

class AccountController extends BaseController {

    public function index(){

        $user = Auth::user();
        $weekly = WeeklyStats::where('user_id', '=', $user->id)->first();
        $overall = UserStats::where('user_id', '=', $user->id)->first();

        $balance = UserBalance::where('user_id', '=', $user->id)->pluck('amount');

        $transactions = Transaction::where('user_id', '=', $user->id)->take(5)->get();
        foreach($transactions as $transaction){
            if($transaction->type == 'c'){
                $transaction->type = 'Credit';
            }
            else{
                $transaction->type = 'Debit';
            }
        }

        return View::make('account.index')->with(array(
            'user' => $user,
            'weekly' => $weekly,
            'overall' => $overall,
            'balance' => $balance,
            'transactions' => $transactions
        ));
    }

    public function edit(){
        $user = Auth::user();

        return View::make('account.edit')->with(array(
            'user' => $user
        ));
    }

    public function doEdit(){
        $user = Auth::user();
        $input = Input::all();

        $rules = array(
            'username' =>   'required|min:3|max:24|unique:users,username,'.$user->id,
            'email'    =>   'required|max:100|email|unique:users,email,'.$user->id,
            'facebook' => 'url|max:100|regex:/^(http(s)?:\/\/)?(www.)?facebook.com\/(.)+$/',
            'twitter' => 'url|max:100|regex:/^(http(s)?:\/\/)?(www.)?twitter.com\/(.)+$/',
            'pinterest' => 'url|max:100|regex:/^(http(s)?:\/\/)?(www.)?pinterest.com\/(.)+$/',
            'website' => 'url|max:100',
            'hometown' => 'max:30',
            'location' => 'max:30',
            'hobbies' => 'max:45'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = $user->edit($input);

        return Redirect::back();
    }

    public function stats(){
        $user = Auth::user();

        $weekly = WeeklyStats::where('user_id', '=', $user->id)->first();
        $overall = UserStats::where('user_id', '=', $user->id)->first();

        $top_recipes = Recipe::where('author_id', '=', $user->id)->orderBy('page_views', 'desc')->take(5)->get();
        $top_reviews = Review::where('reviewer_id', '=', $user->id)->orderBy(DB::raw('`helpful` - `non_helpful`'), 'DESC')->take(5)->get();
        foreach($top_reviews as $review){
            $review->recipe = Recipe::find($review->recipe_id);
        }

        return View::make('account.stats')->with(array(
            'user' => $user,
            'weekly' => $weekly,
            'overall' => $overall,
            'top_recipes' => $top_recipes,
            'top_reviews' => $top_reviews
        ));
    }

    public function recipeStats(){
        $user = Auth::user();

        $recipes = Recipe::where('author_id', '=', $user->id)->orderBy('page_views', 'desc')->paginate(25);

        return View::make('account.recipeStats')->with(array(
            'user' => $user,
            'recipes' => $recipes
        ));
    }

    public function reviewStats(){
        $user = Auth::user();

        $reviews = Review::where('reviewer_id', '=', $user->id)->orderBy(DB::raw('`helpful` - `non_helpful`'), 'DESC')->paginate(51);
        foreach($reviews as $review){
            $review->recipe = Recipe::find($review->recipe_id);
        }

        return View::make('account.reviewStats')->with(array(
            'user' => $user,
            'reviews' => $reviews
        ));
    }

    public function archive(){
        $user = Auth::user();

        $current = WeeklyStats::where('user_id', '=', $user->id)->first();
        $archives = WeeklyStatsArchive::where('user_id', '=', $user->id)->orderBy('start', 'desc')->paginate(25);

        return View::make('account.archive')->with(array(
            'user' => $user,
            'current' => $current,
            'archives' => $archives
        ));
    }

    public function payments(){
        $user = Auth::user();

        $balance = UserBalance::where('user_id', '=', $user->id)->pluck('amount');
        $transactions = Transaction::where('user_id', '=', $user->id)->take(5)->get();
        foreach($transactions as $transaction){
            if($transaction->type == 'c'){
                $transaction->type = 'Credit';
            }
            else{
                $transaction->type = 'Debit';
            }
        }

        $secured = PaymentSecurity::where('user_id', '=', $user->id)->first();
        if(!$secured){
            return View::make('account.payment_security')->with(array(
                'user' => $user
            ));
        }
        $in_queue = PaymentQueue::where('user_id', '=', $user->id)->first();

        return View::make('account.payments')->with(array(
            'user' => $user,
            'balance' => $balance,
            'transactions' => $transactions,
            'secured' => $secured,
            'in_queue' => $in_queue
        ));
    }

    public function paymentsSetup(){
        $user = Auth::user();
        $input = Input::all();

        if(!($input['question'] && $input['question'])){
            return Redirect::back();
        }
        PaymentSecurity::make($input, $user);

        return Redirect::to('account/payments');
    }

    public function createPayout(){
        $user_id = Auth::id();
        $secured = PaymentSecurity::where('user_id', '=', $user_id)->first();
        if(PaymentQueue::where('user_id', '=', $user_id)->first() || !$secured){
            return Redirect::back();
        }
        if(!Hash::check(strtolower(Input::get('answer')), $secured->security_answer)){
            Session::put('wrong_answer', true);
            return Redirect::back();
        }

        $balance = UserBalance::where('user_id', '=', $user_id)->pluck('amount');
        $paypal_email = Input::get('paypal_email');

        PaymentQueue::add($user_id, $balance, $paypal_email);

        return Redirect::back();
    }
}
