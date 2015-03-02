@extends('content.templates.default')

@section('content')
    {{ ViewHelper::getBreadcrumbs(null, 'Contact') }}
    <div class="row">

        <div class="col-xs-12 col-sm-3">
            <ul id="about-menu">
                <li>
                    <a href="{{ url('about') }}">About</a>
                    <div class="left-fill"></div>
                </li>
                <li class="active"><a href="{{ url('contact') }}">Contact</a><div class="left-fill"></div></li>
            </ul>
        </div>
        <div class="col-xs-12 col-sm-9">
            <div id="contact">
                <h1>Contact</h1>
                @if(Session::pull('message_sent', 0))
                    <p>Message sent successfully</p>
                @endif
                {{ Form::open(array('url' => 'contact')) }}
                <div class="row">
                    <div class="col-xs-12 col-sm-2">
                        <label>name:</label>
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <input type="text" name="name" />
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <label>email:</label>
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <input type="email" name="email" />
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <label>subject:</label>
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <input type="text" name="subject" />
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <label>message:</label>
                    </div>
                    <div class="col-xs-12 col-sm-10">
                        <textarea name="message"></textarea>
                    </div>
                    <div class="col-xs-12">
                        <input type="submit" class="flat-button flat-button-green" value="Send Message" />
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    @include('layout.back_to_top')
@stop