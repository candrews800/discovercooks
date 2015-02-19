<?php $css="about"; ?>

@include ('layout.header')
<div class="white-bg content-top">
    <div class="container-fluid">
        {{ ViewHelper::getBreadcrumbs(null, 'Terms and Conditions') }}
    </div>

    <div class="container-fluid">
        <div class="row">

        <div id="terms-and-conditions" class="col-xs-12">
            <h1>Terms and Conditions</h1>

            {{ nl2br($terms->text) }}
        </div>

    </div>

@include ('layout.footer')