<!DOCTYPE html>
<html lang="en" ng-app="cookbookApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>discoverCooks</title>

    <!-- Fonts -->
    <script src="//use.typekit.net/myp5wyo.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>


    <!-- Reset -->
    <link href="{{ url('assets/css/reset.css') }}" rel="stylesheet" />

    <!-- Bootstrap -->
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Site Specific CSS -->
    <link href="{{ url('assets/css/base.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/css/'.$css.'.css') }}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="page-wrap">
    <header id="sticky-nav">
        <nav class="navbar navbar-green navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img id="logo" src="{{ url('assets/img/logo-green.png') }}" />
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    {{ Form::open(array('url' => 'search', 'class' => 'visible-sm visible-xs')) }}
                    {{ Form::text('search_text', null, array('placeholder' => 'Search')) }}
                    {{ Form::close() }}

                    <ul class="nav navbar-nav">
                        <li class="dropdown clearfix">
                            <a href="#" class="dropdown-toggle menu-item" data-toggle="dropdown" role="button" aria-expanded="false">RECIPES <i class="caret"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <div id="recipes-dropdown" class="clearfix">
                                @foreach($top_categories as $category)
                                    @if($category->recipe)
                                        <li class="clearfix">
                                            <a class="category" href="{{ url('category/'.$category->name) }}">{{ $category->name }}</a>
                                            <div class="recipes-dropdown-recipe">
                                                <a href="{{ url('recipe/'.$category->recipe->slug) }}"><img src="{{ url(ViewHelper::getRecipeImage($category->recipe->image)) }}" /></a>
                                                <h3><a href="{{ url('recipe/'.$category->recipe->slug) }}">{{ $category->recipe->name }}</a></h3>
                                                <a class="recipes-author-dropdown" href="{{ url('profile/'.$category->user->username) }}">{{ $category->user->username }}</a>
                                                <p>
                                                    {{ $category->recipe->description }}
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                </div>
                            </ul>
                        </li>
                        <li><a href="{{ url('forum') }}" class="menu-item">FORUMS</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">

                        <li id="new-recipe-header">
                            @if(Auth::guest())
                            <a class="menu-item" href="#" data-toggle="modal" data-target="#guest-login-modal"><i class="glyphicon glyphicon-plus"></i><i class="glyphicon glyphicon-cutlery"></i></a>
                            @else
                            <a class="menu-item" href="{{ url('recipe/new') }}" title="Add New Recipe"><i class="glyphicon glyphicon-plus"></i><i class="glyphicon glyphicon-cutlery"></i></a>
                            @endif

                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle menu-item" data-toggle="dropdown" role="button" aria-expanded="false"><i class="glyphicon glyphicon-user"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                @if(Auth::guest())
                                    <li><a class="menu-item" href="#" data-toggle="modal" data-target="#guest-login-modal">login<span></a></li>
                                    <li><a class="menu-item" href="#" data-toggle="modal" data-target="#guest-register-modal">register<span></a></li>
                                @else
                                    <li><a class="menu-item" href="{{ url('profile/'.Auth::user()->username) }}">profile</a></li>
                                    <li><a class="menu-item" href="{{ url('cookbook/'.Auth::user()->username) }}"><span>my</span>Cookbook</a></li>
                                    <li><a class="menu-item" href="{{ url('users/logout') }}">logout<span></a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>

                    {{ Form::open(array('url' => 'search', 'class' => 'navbar-form navbar-right visible-md visible-lg')) }}
                        {{ Form::text('search_text', null, array('placeholder' => 'Search')) }}
                    {{ Form::close() }}

                </div><!--/.nav-collapse -->
            </div>
        </nav>



        <!-- Login Modal -->
        <div class="modal" id="guest-login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header clearfix">
                        <a class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                    </div>
                    <div class="modal-body">
                        <img id="alt-logo" src="{{ url('assets/img/logo-white.png') }}" />
                        <p>Sign in to access your cookbook from anywhere.</p>

                        {{ Form::open(array('url' => URL::to('/users/login'), 'id' => 'login-form', 'class' => 'row')) }}
                        <div class="col-xs-12 col-sm-6">
                            <p>Login <span>exisiting users</span></p>
                            @if($login_error_msg = Session::pull('login_error_msg', false))
                                <span class="input-error">{{ $login_error_msg }}</span>
                            @endif
                            {{ Form::text('email', null, array('placeholder' => 'Email', 'required' => 'required', 'autofocus' => 'autofocus')) }}
                            {{ Form::password('password', array('placeholder' => 'Password', 'required' => 'required')) }}
                            <div class="clearfix">
                                <label class="myCheckbox">
                                    <input type="checkbox" id="remember" name="remember"/>
                                    <span></span>
                                </label>
                                <label for="remember">Remember me</label>

                                <a id="forgot_password_link" href="#" data-toggle="modal" data-target="#forgot-password-modal">Forgot Password?</a>
                            </div>
                            {{ Form::submit('login', array('class' => 'flat-button flat-button-green')) }}
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div id="new-user">
                                <p>New User? <span>sign up now</span></p>
                                <ul>
                                    <li>• Register in seconds</li>
                                    <li>• Access your cookbook from anywhere.</li>
                                    <li>• Create and share your recipes.</li>
                                </ul>
                            </div>
                            <a id="join_now_link" href="#" class="flat-button">Join now for free!</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Register Modal -->
        <div class="modal" id="guest-register-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header clearfix">
                        <a class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                    </div>
                    <div class="modal-body">
                        <a id="member_already_link" class="alt-link" href="#">Member? Log in here.</a>
                        <img id="alt-logo" src="{{ url('assets/img/logo-white.png') }}" />
                        <p>Join for free now to access your cookbook from anywhere.</p>

                        <form id="register-form" class="row" method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
                            <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                            <div class="col-xs-12 col-sm-6">
                                {{ $errors->register->first('username', '<span class="input-error">:message</span>') }}
                                <input type="text" name="username" placeholder="Username (what others see)" value="{{{ Input::old('username') }}}" autofocus />
                                {{ $errors->register->first('email', '<span class="input-error">:message</span>') }}
                                <input type="email" name="email" placeholder="Email" value="{{{ Input::old('email') }}}" />
                                {{ $errors->register->first('password', '<span class="input-error">:message</span>') }}
                                @if(!$errors->register->first('password'))
                                    {{ $errors->register->first('password_confirmation', '<span class="input-error">:message</span>') }}
                                @endif
                                <input type="password" name="password" placeholder="Password" />
                                <input type="password" name="password_confirmation" placeholder="Password Confirm" />
                            </div>
                            <div class="col-xs-12 col-sm-6 hidden-xs">
                                <div id="why-register">
                                    <ul>
                                        <li id="register-header">Register In Seconds</li>
                                        <li>• Save your favorite recipes</li>
                                        <li>• Always free</li>
                                        <li>• We never share your email or personal information.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <label class="myCheckbox">
                                    <input type="checkbox" id="terms-agree" name="terms-agree" />
                                    <span></span>
                                    I am 13 years of age or older and agree to the <a href="{{ url('terms') }}">Terms and Conditions</a></label>
                                </label>
                            </div>
                            <div class="col-xs-12">
                                <input id="register-submit-button" name="register-submit-button" type="submit" class="flat-button" value="register" disabled="disabled" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forgot Password Modal -->
        <div class="modal" id="forgot-password-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header clearfix">
                        <a class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                    </div>
                    <div class="modal-body">
                        <img id="alt-logo" src="{{ url('assets/img/logo-white.png') }}" />

                        {{ Form::open(array('url' => URL::to('/users/forgot_password'), 'id' => 'forgot-password-form', 'class' => 'row')) }}
                        <div class="col-xs-12">
                            <p>Forgot Password? <span>let's get it back</span></p>
                            @if($forgot_password_error_msg = Session::pull('forgot_password_error_msg', false))
                                <span class="input-error">{{ $forgot_password_error_msg }}</span>
                            @endif
                            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}" autofocus>

                            {{ Form::submit(Lang::get('confide::confide.forgot.submit'), array('class' => 'flat-button flat-button-green')) }}
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reset Password Modal -->
        <div class="modal" id="reset-password-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header clearfix">
                        <a class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                    </div>
                    <div class="modal-body">
                        <img id="alt-logo" src="{{ url('assets/img/logo-white.png') }}" />

                        {{ Form::open(array('url' => URL::to('/users/reset_password'), 'id' => 'reset-password-form', 'class' => 'row')) }}
                        @if(isset($token))
                            <input type="hidden" name="token" value="{{{ $token }}}">
                        @endif
                        <div class="col-xs-12">
                            <p>Reset Password <span>try to remember this one</span></p>
                            @if($reset_password_error_msg = Session::pull('reset_password_error_msg', false))
                                <span class="input-error">{{ $reset_password_error_msg }}</span>
                            @endif
                            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password" autofocus>
                            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">

                            {{ Form::submit(Lang::get('confide::confide.forgot.submit'), array('class' => 'flat-button flat-button-green')) }}
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

<section id="content">