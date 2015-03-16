<?php $css="account"; ?>

@include('layout.header')

<div class="container-fluid">
    <div class="row">
        <div id="account-wrap" class="col-xs-12 col-md-8 col-md-offset-2 content-top">
            @section('breadcrumbs')
                {{ ViewHelper::getBreadcrumbs(null, 'Account Overview') }}
            @show
            <div class="row">
                <div id="account-header" class="col-xs-12">
                    <h1>{{ $user->username }}</h1>
                    <div class="account-balance">
                        <p>Account Balance: <span>${{ number_format((float)$balance, 2, '.', '');}}</span></p>
                    </div>
                    <div id="payoff" class="row">
                        <div class="col-xs-12 col-sm-4">
                            <a href="{{ url(Request::url().'/payout') }}" class="flat-button flat-button-green flat-button-small">Request Payout</a>
                            <p>Min: $15.00</p>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
            @include('layout.back_to_top')
        </div>
    </div>
</div>

@include('layout.footer')

@yield('javascript')