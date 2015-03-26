<?php $css="account"; ?>

@include('style.layout.header')

<div class="white-bg">
    <div class="container-fluid">
        <div class="row">
            <div id="account-wrap" class="col-xs-12 content-top">
                @section('breadcrumbs')
                    {{ ViewHelper::getNewBreadcrumbs(null, 'Account Overview') }}
                @show
                <div class="row">
                    <div id="account-header" class="col-xs-12 visible-xs">
                        <ul class="nav nav-pills clearfix">
                            <li role="presentation" <?php if($active=='overview') echo 'class="active"'; ?>><a href="{{ url('account') }}">Overview</a></li>
                            <li role="presentation" <?php if($active=='edit') echo 'class="active"'; ?>><a href="{{ url('account/edit') }}">Edit Profile</a></li>
                            <li role="presentation" <?php if($active=='stats') echo 'class="active"'; ?>><a href="{{ url('account/stats') }}">Statistics</a></li>
                            <li role="presentation" <?php if($active=='payments') echo 'class="active"'; ?>><a href="{{ url('account/payments') }}">Payments Center</a></li>
                        </ul>
                    </div>
                    <div id="account-header" class="col-xs-3 hidden-xs">
                        <ul class="nav nav-pills nav-stacked clearfix">
                            <li role="presentation" <?php if($active=='overview') echo 'class="active"'; ?>><a href="{{ url('account') }}">Overview</a></li>
                            <li role="presentation" <?php if($active=='edit') echo 'class="active"'; ?>><a href="{{ url('account/edit') }}">Edit Profile</a></li>
                            <li role="presentation" <?php if($active=='stats') echo 'class="active"'; ?>><a href="{{ url('account/stats') }}">Statistics</a></li>
                            <li role="presentation" <?php if($active=='payments') echo 'class="active"'; ?>><a href="{{ url('account/payments') }}">Payments Center</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-9">
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('style.layout.footer')

@yield('javascript')