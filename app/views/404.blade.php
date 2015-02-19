<?php $css="about"; ?>

@include ('layout.header')
<div class="white-bg content-top">
    <div class="container-fluid">
    {{ ViewHelper::getBreadcrumbs(null, 'Page Not Found') }}

        <div class="container-fluid">
            <div class="row">

                <div id="not-found" class="col-xs-12">
                    <h1>Wooops, you seem to be lost.</h1>

                    <p>If you feel you've reached this in error, please feel free to <a href="{{ url('contact') }}">contact us and let us know.</a></p>
                </div>
            </div>
        </div>
@include ('layout.footer')