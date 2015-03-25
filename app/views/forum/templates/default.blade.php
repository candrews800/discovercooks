<?php $css="forum"; ?>

@include('style.layout.header')

<div class="container-fluid">
    <div class="row">
        <div id="forum-wrap" class="col-xs-12">
            @section('breadcrumbs')
                {{ ViewHelper::getNewBreadcrumbs(null, 'Forums') }}
            @show
            <div class="row">
                <div class="col-xs-12">
                    <h1>
                        @yield('header')
                    </h1>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('style.layout.footer')

@yield('javascript')