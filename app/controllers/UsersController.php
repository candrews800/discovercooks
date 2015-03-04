<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{

    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        return View::make(Config::get('confide::signup_form'));
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {
        $repo = App::make('UserRepository');
        $user = $repo->signup(Input::all());

        if ($user->id) {
            if (Config::get('confide::signup_email')) {
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->username)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }

            Auth::login($user);

            return Redirect::back();
        } else {
            Session::put('register_error', true);
            return Redirect::back()
                ->withInput(Input::except('password'))
                ->withErrors($user->errors(), 'register');
        }
    }

    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
        if (Confide::user()) {
            return Redirect::to('/');
        } else {
            Session::put('login_error', true);
            return View::make('/');
        }
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {
        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
            return Redirect::back();
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            Session::put('login_error', true);
            return Redirect::back()
                ->withInput(Input::except('password'))
                ->with('login_error_msg', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('UsersController@login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make('forgot_password');
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            Session::put('forgot_password_error', true);
            return Redirect::back()
                ->withInput()
                ->with('forgot_password_error_msg', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            Session::put('forgot_password_error', true);
            return Redirect::back()
                ->withInput()
                ->with('forgot_password_error_msg', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        Session::put('reset_password_error', true);
        Session::put('token', $token);
        return Redirect::to('/');
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );

        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            Session::put('login_error', true);
            return Redirect::to('/')
                ->with('login_error_msg', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            Session::put('reset_password_error', true);
            return Redirect::back()
                ->with('reset_password_error_msg', $error_msg);
        }
    }

    public function changeSettings(){
        $user = Auth::user();

        if( ! Hash::check(Input::get('current_password'), $user->password)){
            return Redirect::back()->with('settings_password_error', true);
        }

        $input = Input::all();
        $rules = array(
            'username' =>   'min:3|max:24|unique:users,username,'.$user->id,
            'email'    =>   'email|unique:users,email,'.$user->id
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator, 'changeSettings');
        }

        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->save();

        return Redirect::back();
    }

    public function changePassword(){
        $user = Auth::user();

        if( ! Hash::check(Input::get('old_password'), $user->password)){
            Session::put('change_password_error', true);
            return Redirect::back();
        }

        if (Input::get('new_password') != Input::get('confirm_password')){
            Session::put('password_match_error', true);
            return Redirect::back();
        }

        $new_password = array('new_password' => Input::get('new_password'));
        $password_rules = array('new_password' => 'min:6');

        $validator = Validator::make($new_password, $password_rules);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $user->password = Input::get('new_password');
        $user->password_confirmation = $user->password;
        $user->save();

        Session::put('password_reset_success', true);
        return Redirect::back();
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {
        Confide::logout();

        return Redirect::back();
    }
}
