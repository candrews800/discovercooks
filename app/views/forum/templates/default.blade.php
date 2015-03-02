<?php $css="forum"; ?>

@include('layout.header')

<div class="container-fluid">
    <div class="row">
        <div id="forum-wrap" class="col-xs-12 col-md-8 col-md-offset-2 content-top">
            @section('breadcrumbs')
                {{ ViewHelper::getBreadcrumbs(null, 'Forums') }}
            @show
            <div class="row">
                <div class="col-xs-12">
                    <h1>
                        @yield('header')
                    </h1>
                </div>
                @yield('content')
            </div>
            @include('layout.back_to_top')
        </div>
    </div>
</div>

@include('layout.footer')

@yield('javascript')