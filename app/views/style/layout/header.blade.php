
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <link rel="icon" href="{{ url('favicon.ico') }}">

    @if(isset($description))
        <meta name="description" content="{{ $description }}">
    @else
        <meta name="description" content="DiscoverCooks has the best recipes from every type of chef. We attract the best cooks who share their best recipes since we split a portion of our revenue with them!">
    @endif

    @if(isset($title))
        <title>{{ $title }} - DiscoverCooks</title>
    @else
        <title>DiscoverCooks</title>
    @endif

    <script src="//use.typekit.net/myp5wyo.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('style_assets/style.css') }}" rel="stylesheet">

    @if(isset($css))
    <link href="{{ url('assets/css/base.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/css/'.$css.'.css') }}" rel="stylesheet" />
    @endif

    <link rel="stylesheet" type="text/css" href="{{ url('assets/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('assets/slick/slick-theme.css') }}"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body role="document">
<header>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img id="logo" class="img-responsive" src="{{ url('assets/img/logo-white.png') }}" />
                </a>
            </div>
            <div id="navbar" class="navbar-primary navbar-collapse collapse ">
                <ul class="nav navbar-nav navbar-right hidden-xs">
                    <li class="navbar-dropdown" data-target="recipes"><a href="#">RECIPES</a></li>
                    <li class="navbar-dropdown" data-target="discover"><a href="#">DISCOVER</a></li>
                    <li><a href="{{ url('forum') }}">FORUMS</a></li>
                    <li id="navbar-search"><a href="#"><i class="glyphicon glyphicon-search"></i></a></li>

                    {{ Form::open(array('url' => 'search', 'id' => 'navbar-search-form', 'class' => 'navbar-form', 'role' => 'search')) }}
                    {{ Form::text('search_text', null, array('class' => 'form-control', 'placeholder' => 'Search for recipes, users')) }}
                    {{ Form::close() }}
                </ul>

                <ul class="nav navbar-nav navbar-right visible-xs">
                    {{ Form::open(array('url' => 'search', 'class' => 'navbar-form navbar-left', 'role' => 'search')) }}
                        <div class="form-group">
                            {{ Form::text('search_text', null, array('class' => 'form-control', 'placeholder' => 'Search for recipes, users')) }}
                        </div>
                    {{ Form::close() }}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">RECIPES <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Browse All</a></li>
                            <li><a href="#">Breakfast</a></li>
                            <li><a href="#">Lunch</a></li>
                            <li><a href="#">Dinner</a></li>
                        </ul>
                    </li>
                    <li><a href="#">DISCOVER</a></li>
                    <li><a href="{{ url('forum') }}">FORUMS</a></li>
                    @if(Auth::guest())
                        <li><a href="#" data-toggle="modal" data-target="#guest-register-modal">REGISTER</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#guest-login-modal">LOGIN</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->username }} <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('profile/'.Auth::user()->username) }}">PROFILE</a></li>
                                <li><a href="{{ url('account') }}">MY ACCOUNT</a></li>
                                <li><a href="{{ url('cookbook/'.Auth::user()->username) }}">MY COOKBOOK</a></li>
                                <li><a href="{{ url('recipe/new') }}">NEW RECIPE</a></li>
                                <li><a href="{{ url('users/logout') }}">LOGOUT<span></a></li>
                            </ul>
                        </li>

                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
        <div id="navbar-dropdown">
            <div class="container-fluid">
                <div id="recipesDropdown" class="navbar-dropdown-contents">
                    <ul>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/category_images/Dinner.jpeg" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Browse All</span>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/category_images/Lunch.jpeg" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Breakfast</span>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/category_images/Breakfast.jpeg" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Lunch</span>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/recipe_images/Hamburgers-4.jpeg" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Dinner</span>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/recipe_images/Hamburgers%20and%20Hotdogs-4.png" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Snacks</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="discoverDropdown" class="navbar-dropdown-contents">
                    <ul>
                        <li class="text-only">
                            <h1>Find new cooks...</h1>
                            <p>Browse our listing of the top professional and amateur cooks on the net.</p>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/category_images/Dinner.jpeg" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Browse All</span>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/recipe_images/Hamburgers-4.jpeg" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Popular</span>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <img src="http://localhost/cookbook/public/recipe_images/Hamburgers-4.jpeg" class="img-circle" />
                                <div class="img-shadow"></div>
                                <span>Rising</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="navbar-secondary">
            <div class="container-fluid">
                <ul class="nav navbar-nav navbar-left">
                    @if(Auth::guest())
                        <li><a href="#" data-toggle="modal" data-target="#guest-login-modal"><i class="glyphicon glyphicon-heart-empty"></i> SIGN IN TO SAVE RECIPES</a></li>
                    @else
                        <li><a href="{{ url('cookbook/'.Auth::user()->username) }}"><i class="glyphicon glyphicon-heart"></i> <em>my</em>COOKBOOK</a></li>
                        <li><a href="{{ url('recipe/new') }}"><i class="glyphicon glyphicon-cutlery"></i> NEW RECIPE</a></li>
                    @endif
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::guest())
                        <li><a href="#" data-toggle="modal" data-target="#guest-register-modal">REGISTER</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#guest-login-modal">LOGIN</a></li>
                    @else
                        <li><a href="{{ url('profile/'.Auth::user()->username) }}">PROFILE</a></li>
                        <li><a href="{{ url('account') }}">MY ACCOUNT</a></li>
                        <li><a href="{{ url('users/logout') }}">LOGOUT<span></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div class="modal" id="guest-login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header clearfix">
                    <a class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                </div>
                <div class="modal-body">
                    <div class="modal-brand">
                        <img src="{{ url('assets/img/logo-white.png') }}" />
                        <h4><em>Sign in to access your favorites.</em></h4>
                    </div>

                    {{ Form::open(array('url' => URL::to('/users/login'), 'id' => 'login-form', 'class' => 'row')) }}
                    <div class="col-xs-12">
                        <h3>Login <small>existing users</small></h3>

                        @if($login_error_msg = Session::pull('login_error_msg', false))
                            <span class="text-danger">{{ $login_error_msg }}</span>
                        @endif
                        {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required', 'autofocus' => 'autofocus')) }}
                        {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password', 'required' => 'required')) }}
                        <div class="clearfix">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="remember" name="remember" checked="checked" /> Remember me
                                </label>
                                <a id="forgot_password_link" class="related-link" href="#" data-toggle="modal" data-target="#forgot-password-modal">Forgot Password?</a>
                            </div>
                        </div>
                        {{ Form::submit('login', array('class' => 'btn btn-lg btn-info btn-block')) }}
                    </div>
                    {{ Form::close() }}

                    <h4 class="text-center">
                        New to DiscoverCooks? <a id="join_now_link" href="#" class="btn">Join now for free!</a>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal" id="guest-register-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header clearfix">
                    <a class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                </div>
                <div class="modal-body">
                    <p class="text-right">
                        <a id="member_already_link" class="alt-link" href="#">Member? Log in here.</a>
                    </p>
                    <div class="modal-brand">
                        <img src="{{ url('assets/img/logo-white.png') }}" />
                        <p>You're 15 seconds away from saving your favorites recipes and cooks.</p>
                    </div>

                    <form id="register-form" class="row" method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
                        <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
                        <div class="col-xs-12">
                            <h3>Register <small>new users - it's free!</small></h3>
                            <div class="form-group <?php if($errors->register->first('username')){echo 'has-error';} ?>">
                                {{ $errors->register->first('username', '<span class="text-danger">:message</span>') }}
                                <input type="text" name="username" class="form-control" placeholder="Username" value="{{{ Input::old('username') }}}" autofocus />
                            </div>

                            <div class="form-group <?php if($errors->register->first('email')){echo 'has-error';} ?>">
                                {{ $errors->register->first('email', '<span class="text-danger">:message</span>') }}
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{{ Input::old('email') }}}" />
                            </div>

                            {{ $errors->register->first('password', '<span class="text-danger">:message</span>') }}
                            @if(!$errors->register->first('password'))
                                {{ $errors->register->first('password_confirmation', '<span class="text-danger">:message</span>') }}
                            @endif
                            <input type="password" class="form-control" name="password" placeholder="Password" />
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirm" />
                            <div class="clearfix">
                                <div class="checkbox">
                                    <label id="terms-agree-popover" data-container="body" data-toggle="popover" data-placement="top" data-content="You must agree to the Terms to register.">
                                        <input type="checkbox" id="terms-agree" name="terms-agree" /> I am 13 years of age or older and agree to the <a href="{{ url('terms') }}">Terms of Service</a>
                                    </label>
                                </div>
                            </div>
                            <input id="register-submit-button" name="register-submit-button" type="submit" class="btn btn-lg btn-block btn-info" value="register" disabled="disabled" />
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
                    <div class="modal-brand">
                        <img src="{{ url('assets/img/logo-white.png') }}" />
                    </div>


                    {{ Form::open(array('url' => URL::to('/users/forgot_password'), 'id' => 'forgot-password-form', 'class' => 'row')) }}
                    <div class="col-xs-12">
                        <h3>Forgot Password? <small>let's get it back</small></h3>
                        @if($forgot_password_error_msg = Session::pull('forgot_password_error_msg', false))
                            <span class="text-danger">{{ $forgot_password_error_msg }}</span>
                        @endif
                        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="{{{ Input::old('email') }}}" autofocus>

                        {{ Form::submit(Lang::get('confide::confide.forgot.submit'), array('class' => 'btn btn-lg btn-block btn-info')) }}
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
                    <div class="modal-brand">
                        <img src="{{ url('assets/img/logo-white.png') }}" />
                    </div>

                    {{ Form::open(array('url' => URL::to('/users/reset_password'), 'id' => 'reset-password-form', 'class' => 'row')) }}
                    @if(isset($token))
                        <input type="hidden" name="token" value="{{{ $token }}}">
                    @endif
                    <div class="col-xs-12">
                        <h3>Reset Password <small>try to remember this one</small></h3>
                        @if($reset_password_error_msg = Session::pull('reset_password_error_msg', false))
                            <span class="text-danger">{{ $reset_password_error_msg }}</span>
                        @endif
                        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password" autofocus>
                        <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">

                        {{ Form::submit(Lang::get('confide::confide.forgot.submit'), array('class' => 'btn btn-lg btn-block btn-info')) }}
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</header>