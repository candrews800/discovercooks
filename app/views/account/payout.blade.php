@extends('account.templates.default')

@section('content')

    <div class="col-xs-12">
        <p>Payments will be processed within 2 business days.</p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        {{ Form::open(array('url' => Request::url())) }}
            {{ Form::email('paypal_email', null, array('placeholder' => 'Paypal Email')) }}

            {{ Form::submit('Send Money', array('class' => 'flat-button flat-button-small')) }}
        {{ Form::close() }}
    </div>

@stop

@section('javascript')

@stop