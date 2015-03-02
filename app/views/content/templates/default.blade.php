<?php $css="about"; ?>

@include ('layout.header')
<div class="container-fluid">
    <div class="row">
        <div class="white-bg content-top col-xs-12 col-md-8 col-md-offset-2">
            @yield('content')
        </div>
    </div>
</div>

@include ('layout.footer')