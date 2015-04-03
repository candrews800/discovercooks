<?php $title = 'Contact'; ?>

@extends('content.templates.default')

@section('content')
    {{ ViewHelper::getNewBreadcrumbs(null, 'Contact') }}
    <h1>Contact</h1>
    @if(Session::pull('message_sent', 0))
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Message sent successfully. We will try to get back to you shortly. Thank you for your patience.
        </div>
    @endif
    {{ Form::open(array('url' => 'contact')) }}
        <div class="form-group">
            <label>Your Name</label>
            {{ Form::text('name', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            <label>Your Email</label>
            {{ Form::email('email', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            <label>Subject</label>
            {{ Form::text('subject', null, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            <label>Message</label>
            {{ Form::textarea('message', null, array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Send Message', array('class' => 'btn btn-info')) }}
    {{ Form::close() }}
@stop