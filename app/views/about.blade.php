<?php $css="about"; ?>

@include ('layout.header')
<div class="white-bg content-top">
    <div class="container-fluid">
        {{ ViewHelper::getBreadcrumbs(null, 'About') }}
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <ul id="about-menu">
                    <li class="active">
                        <a href="{{ url('about') }}">About</a>
                        <div class="left-fill"></div>
                    </li>
                    <li><a href="{{ url('contact') }}">Contact</a><div class="left-fill"></div></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-9">
                <div id="about-content">
                    <h1>About discoverCooks</h1>
                    <p>
                        {{ nl2br($about->text) }}
                    </p>
                </div>
            </div>
        </div>

@include ('layout.footer')