<footer>
    <nav class="nav-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-3 col-lg-2 text-center-xs text-center-sm text-center-md">
                    <h5>DISCOVERCOOKS</h5>
                    <ul>
                        <li><a href="{{ url('about') }}"><small>ABOUT</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-2 text-center-xs text-center-sm text-center-md">
                    <h5>EARN</h5>
                    <ul>
                        <li><a href="{{ url('earn') }}"><small>OVERVIEW</small></a></li>
                        <li><a href="{{ url('earn') }}#ways-to-earn"><small>WAYS TO EARN</small></a></li>
                        <li><a href="{{ url('earn') }}#faq"><small>FAQ</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-2 text-center-xs text-center-sm text-center-md">
                    <h5>CONNECT</h5>
                    <ul>
                        <li><a href="https://www.facebook.com/discovercooks"><small>FACEBOOK</small></a></li>
                        <li><a href="https://twitter.com/DiscoverCook"><small>TWITTER</small></a></li>
                        <li><a href="https://www.pinterest.com/discovercooks/"><small>PINTEREST</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-2 text-center-xs text-center-sm text-center-md">
                    <h5>SUPPORT</h5>
                    <ul>
                        <li><a href="{{ url('contact') }}"><small>CONTACT</small></a></li>
                        <li><a href="{{ url('recipe-guidelines') }}"><small>RECIPE GUIDELINES</small></a></li>
                        <li><a href="{{ url('terms') }}"><small>TERMS OF SERVICE</small></a></li>
                        <li><a href="{{ url('terms') }}#privacy"><small>PRIVACY POLICY</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-0 text-left text-center-xs text-center-sm text-center-md">
                    <h5>SIGN UP FOR OUR NEWSLETTER</h5>
                    @if($email = Session::pull('newsletter_signup_success'))
                        <p class="text-success">{{ $email }} was added to the newsletter.</p>
                    @endif
                    <form action="{{ url('newsletter_signup') }}" method="post">
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter your email..." required >
                            <span class="input-group-btn">
                                <input class="btn btn-info" type="submit" value="Sign Up">
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <nav class="nav-footer-secondary">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-6 text-center-xs text-center-sm">
                    <p>Copyright © 2015 DiscoverCooks.com</p>
                </div>
                <div class="col-xs-12 col-md-6 text-right text-center-xs text-center-sm">
                    <p>By accessing this site, you agree to our <a href="{{ url('terms') }}">Terms of Service</a>.</p>
                </div>
                <div class="col-xs-12 col-md-6 text-center-xs text-center-sm hidden-xs hidden-sm">
                    <p><em class="text-muted">v.1.0</em></p>
                </div>
                <div class="col-xs-12 col-md-6 text-right text-center-xs text-center-sm">
                    <p>All rights reserved.</p>
                </div>
                <div class="col-xs-12 col-md-6 text-center-xs text-center-sm visible-xs visible-sm">
                    <p><em class="text-muted">v.1.0</em></p>
                </div>
            </div>
        </div>
    </nav>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
<script src="{{ url('style_assets/javascripts/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/slick/slick.min.js') }}"></script>


<script src="{{ url('assets/Masonry/masonry.js') }}"></script>
<script src="{{ url('assets/imagesLoaded/imagesLoaded.min.js') }}"></script>
<script src="{{ url('build/production.min.js') }}" type="text/javascript"></script>

<script src="//use.typekit.net/myp5wyo.js"></script>
<script>try{Typekit.load();}catch(e){}</script>

</body>
</html>

<script src="{{ url('style_assets/javascripts/custom.js') }}"></script>

@if(Session::pull('register_error', false))
    <script>
        $('#guest-register-modal').modal('show');
    </script>
@endif

@if(Session::pull('login_error', false))
    <script>
        $('#guest-login-modal').modal('show');
    </script>
@endif

@if(Session::pull('forgot_password_error', false))
    <script>
        $('#forgot-password-modal').modal('show');
    </script>
@endif

@if(Session::pull('reset_password_error', false))
    <script>
        $('#reset-password-modal').modal('show');
    </script>
@endif

<script>
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });
</script>