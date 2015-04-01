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
                    <h5>SUPPORT</h5>
                    <ul>
                        <li><a href="{{ url('contact') }}"><small>CONTACT</small></a></li>
                        <li><a href="{{ url('recipe-guidelines') }}"><small>RECIPE GUIDELINES</small></a></li>
                        <li><a href="{{ url('terms') }}"><small>TERMS OF SERVICE</small></a></li>
                        <li><a href="{{ url('terms') }}#privacy"><small>PRIVACY POLICY</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-3 col-lg-2 text-center-xs text-center-sm text-center-md">
                    <h5>CONNECT</h5>
                    <ul>
                        <li><a href="#"><small>FACEBOOK</small></a></li>
                        <li><a href="#"><small>TWITTER</small></a></li>
                        <li><a href="#"><small>PINTEREST</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-lg-4 text-left text-center-xs text-center-sm text-center-md">
                    <h5>SIGN UP FOR OUR NEWSLETTER</h5>
                    <form >
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter your email...">
                            <span class="input-group-btn">
                                <button class="btn btn-info" type="button">Sign up</button>
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
                <div class="col-xs-12 col-md-6 text-center-xs text-center-sm col-xs-push-12">
                    <p><em class="text-muted">v.1.0</em></p>
                </div>
                <div class="col-xs-12 col-md-6 text-right text-center-xs text-center-sm col-xs-pull-12">
                    <p>All rights reserved.</p>
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
<script src="{{ url('assets/js/smoothScroll.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/saveFavorite.js') }}" type="text/javascript"></script>

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