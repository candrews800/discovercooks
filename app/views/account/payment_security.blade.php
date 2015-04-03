<?php $active = 'payments'; ?>
<?php $title = 'Payment Security Setup'; ?>
@extends('account.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('account'), 'text' => 'My Account'
        ),array(
        'url' => url('account/payments'), 'text' => 'Payments Center'
    )), 'First Time') }}
@stop

@section('content')
    <div class="col-xs-12">
        <h3 class="page-header">Payments Setup - New User</h3>
        <p>1. In order to better protect your security, you are required to fill out the following form.</p>
        <p>2. Please write down your answer as it will be required to request payouts.</p>
        <p>3. Please consider using a question that can <u>not</u> be answered easily by visiting a social media site such as "What is your spouse's name?" as in the case of someone having your account info, they will most likely have access to your social media as well.</p>
        {{ Form::open(array('url' => url('account/payments/setUp'))) }}
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group-lg">
                        <label>Create a Security Question (ex. Who was my childhood hero?)</label>
                        {{ Form::text('question', null, array('class' => 'form-control', 'required' => 'required')) }}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group-lg">
                        <label>Security Answer</label>
                        {{ Form::text('answer', null, array('class' => 'form-control', 'required' => 'required')) }}
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-12 col-md-6">
                    {{ Form::submit('Complete Setup', array('class' => 'btn btn-info btn-lg')) }}
                </div>
            </div>
        {{ Form::close() }}

    </div>

@stop

@section('javascript')

@stop