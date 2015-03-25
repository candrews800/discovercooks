<footer>
    <nav class="nav-footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-2">
                    <h5>DISCOVERCOOKS</h5>
                    <ul>
                        <li><a href="#"><small>ABOUT US</small></a></li>
                        <li><a href="#"><small>THE TEAM</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <h5>EARN</h5>
                    <ul>
                        <li><a href="#"><small>OVERVIEW</small></a></li>
                        <li><a href="#"><small>WAYS TO EARN</small></a></li>
                        <li><a href="#"><small>FAQ</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <h5>SUPPORT</h5>
                    <ul>
                        <li><a href="#"><small>CONTACT</small></a></li>
                        <li><a href="#"><small>RECIPE GUIDELINES</small></a></li>
                        <li><a href="#"><small>TERMS AND CONDITIONS</small></a></li>
                        <li><a href="#"><small>PRIVACY POLICY</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <h5>CONNECT</h5>
                    <ul>
                        <li><a href="#"><small>FACEBOOK</small></a></li>
                        <li><a href="#"><small>TWITTER</small></a></li>
                        <li><a href="#"><small>PINTEREST</small></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4">
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
                <div class="col-xs-12 col-md-6">
                    <p>Copyright © 2015 DiscoverCooks.com</p>
                </div>
                <div class="col-xs-12 col-md-6">
                    <p class="text-right">By accessing this site, you agree to our <a href="#">Terms and Conditions</a>.</p>
                </div>
                <div class="col-xs-12 col-md-6">
                    <p><em class="text-muted">v.1.0</em></p>
                </div>
                <div class="col-xs-12 col-md-6">
                    <p class="text-right">ALL RIGHTS RESERVED</p>
                </div>
            </div>
        </div>
    </nav>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="{{ url('style_assets/javascripts/bootstrap.min.js') }}"></script>


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