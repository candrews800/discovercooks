<?php $active = 'payments'; ?>
@extends('account.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('account'), 'text' => 'My Account'
    )), 'Payments Center') }}
@stop

@section('content')
    <div class="col-xs-12">
        <h2 class="page-header">Payments Center</h2>
    </div>
    <div class="col-xs-12">
        @if($in_queue)
            <div class="alert alert-warning" role="alert">
                <p>Your payout was succesfully requested and is in the queue for payout. We try to process all requests within 2 business days.</p>
                <p>Payment will be sent to: {{ $in_queue->paypal_email }}</p>
                <p>Thank you for your patience.</p>
            </div>
        @endif
        <h4>Account Balance: ${{ number_format((float)$balance, 2, '.', ''); }}</h4>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-success active" role="progressbar" aria-valuenow="{{ $balance/15*100 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $balance/15*100 }}%">
                @if($balance/15 >= 1)

                @elseif($balance/15)
                    <span>{{ number_format((float)$balance/15*100, 2, '.', ''); }}% To Payout</span>
                @endif
            </div>
        </div>
        <p class="text-muted">Minimum needed for payout: $15</p>
        @if($balance/15 >= 1 && !$in_queue)
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    {{ Form::open(array('url' => 'account/payments/createPayout')) }}
                        <div class="form-group {{ ViewHelper::addClass('has-error', $wrong_answer = Session::pull('wrong_answer', false)) }}">
                            <label>
                                Security Question - {{ $secured->security_question }}
                                @if($wrong_answer)
                                    <span class="text-danger">Security Answer does not match.</span>
                                @endif
                            </label>
                            {{ Form::text('answer', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            <label>Paypal Email</label>
                            {{ Form::email('paypal_email', null, array('class' => 'form-control')) }}
                        </div>
                        <div class="form-group">
                            {{ Form::submit('Request Payout', array('class' => 'btn btn-info')) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        @elseif($balance/15 <= 1 && !$in_queue)
            <p>
                <a href="{{ url('accounts/payout') }}" class="btn btn-info disabled" role="button">Request Payout</a>
            </p>
        @endif
    </div>

    <div class="col-xs-12">
        <h3>Recent Transactions</h3>
        <table class="table">
            <thead>
            <tr>
                <th class="text-center">Date</th>
                <th class="text-center">Type</th>
                <th class="text-center">Amount</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            @if(!$transactions->isEmpty())
                @foreach($transactions as $transaction)
                    <tr>
                        <td class="text-center">{{ $transaction->created_at->format('Y-m-d') }}</td>
                        <td class="text-center">{{ $transaction->type }}</td>
                        <td class="text-center">${{ number_format((float)$transaction->amount, 2, '.', '')}}</td>
                        <td>{{ $transaction->description }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        @if($transactions->isEmpty())
            <p>
                No transactions found.
            </p>
        @endif
    </div>
@stop

@section('javascript')

@stop