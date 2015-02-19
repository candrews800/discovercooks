<!-- Start Footer -->
    <div id="back-to-top" class="row" onclick="location.href='#';">
        <div class="arrow-up"></div>
        <a href="#">back to top</a>
    </div>
</div>
<footer>
    <div class="black-bg">
        <div class="container-fluid">
            <div class="row">
                <div class="outer-menu clearfix">
                    <div class="col-xs-12 col-md-6">
                        <nav>
                            <ul id="extras-menu" class="clearfix">
                                <li class="home-list-item"><a href="{{ url() }}">discoverCooks.com</li></a>
                                <li><a href="{{ url('about') }}">about</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ url('contact') }}">contact</a></li>
                            </ul>
                        </nav>
                        <p id="version-no" class="visible-md visible-lg">
                            v.1.0
                        </p>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <ul id="copyright">
                            <li>© Copyright 2014</li>
                            <li>ALL RIGHTS RESERVED</li>
                            <li>By accessing this site, you agree to our <a href="{{ url('terms') }}">Terms and Conditions.</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- jQuery UI (Effects) -->
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>

<script src="{{ url('assets/Masonry/masonry.js') }}"></script>

<!-- Mobile Menu -->
<script src="{{ url('assets/mmenu/js/jquery.mmenu.min.all.js') }}" type="text/javascript"></script>
<link href="{{ url('assets/mmenu/css/jquery.mmenu.all.css') }}" type="text/css" rel="stylesheet" />
<script src="{{ url('assets/js/smoothScroll.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/saveFavorite.js') }}" type="text/javascript"></script>
</div>
</body>
</html>

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
    $('#forgot_password_link').click(function(){
        $('#guest-login-modal').modal('hide');
    });
    $('#join_now_link').click(function(){
        $('#guest-login-modal').modal('hide');
        $('#guest-register-modal').modal('show');
    });
    $('#member_already_link').click(function(){
        $('#guest-register-modal').modal('hide');
        $('#guest-login-modal').modal('show');
    });
</script>

<script>
    $('.myCheckbox input').change(function(){
        if($(this).is(':checked')){
            $('#register-submit-button').animate({
                disabled: false,
                opacity: 1.0
            }, 200);
        } else {
            $('#register-submit-button').animate({
                disabled: true,
                opacity: 0.4
            }, 200);
        }
    });
</script>
<script>

    // Search bar resizing

    var searchButton = $('#header-search-button');
    var searchClose = $('#header-search-close');
    var searchInputValue;
    var inputWidth;

    // Need to capture mousedown to trigger submit on form blur
    var clicky;
    $(document).mousedown(function(e) {
        // The latest element clicked
        clicky = $(e.target);
    });

    $('#header-search input').on('blur', function(){
        searchInputValue = $('#header-search-input').val();
        $('#header-search-input').val('');
        searchButton.removeClass('expanded');
        searchClose.removeClass('expanded');
        $(this).removeClass('expanded', 200);
        $(this).animate({
            width: inputWidth
        }, 200, function(){

            $(this).css("background-image","url('assets/img/search-white.png')");
            $(this).attr("placeholder","search");
        });

        // If Blur event triggered by submit button clicked, submit form
        if(clicky.attr('id') == searchButton.attr('id')){
            $('#header-search-form').submit();
        }

    }).on('focus', function(){

        $(this).attr("placeholder","");
        $(this).css("background-image","none");
        inputWidth = $(this).outerWidth();
        $(this).addClass('expanded');
        $(this).animate({
            width: $(this).offset().left - $("#left-menu li").last().offset().left - $("#left-menu li").last().outerWidth() - 10 + inputWidth
        }, 200, function(){
            searchButton.addClass('expanded');
            searchClose.addClass('expanded');
            $('#header-search-input').val(searchInputValue);
        });

    });

</script>

<script>
    // Every time a modal is shown, if it has an autofocus element, focus on it.
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });
</script>

<script type="text/javascript">

    // Mobile Menu

    $(document).ready(function(){

        $("#mobile-menu").mmenu({
            header: true,
        });

    });

    // Mobile Search
    $("#mobile-search-icon").click(function(){
        var formWidth = $("#mobile-header").innerWidth() - 110;
        $("#mobile-search-form input[type=text]").outerWidth(formWidth);

        $(this).animate({
            right: 1000
        }, 200);
        $("#mobile-search-form").show();
        $("#mobile-search-form").animate({
            right: 0
        }, 200, function(){
            $("#mobile-search-form input[type=text]").focus();
        });

    });

    $("#mobile-search-close").click(function(){
        $("#mobile-search-form").animate({
            right: -800
        }, 200, function(){
            $("#mobile-search-form").hide();
        });
        $("#mobile-search-icon").animate({
            right: 0
        }, 200);
    });

</script>