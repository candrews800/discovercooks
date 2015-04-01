<?php $css="about"; ?>

@include ('style.layout.header')
<div class="container-fluid">
    <div class="row">
        <div class="white-bg content-top col-xs-12 col-md-6 col-md-offset-3">
            @yield('content')
        </div>
    </div>
</div>

@include ('style.layout.footer')