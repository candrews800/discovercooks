<?php $active = 'overview'; ?>
<?php $title = 'My Account Overview'; ?>
@extends('account.templates.default')

@section('content')
<div class="col-xs-12">
    <h2 class="page-header">Account Overview</h2>
</div>
<div id="masonry-wrap" class="col-xs-12">
    <div class="row">
        <div class="col-xs-12 col-md-6 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Profile Information <a href="{{ url('account/edit') }}" class="pull-right">Edit</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-sm-push-9">
                            <img src="{{ ViewHelper::getUserImage($user->image) }}" class="img-responsive" />
                        </div>
                        <div class="col-xs-12 col-sm-9 col-sm-pull-3">
                            <h4>{{ $user->username }}</h4>
                            <h5>{{ $user->email }}</h5>

                            @if($user->hometown)
                                <h5><small>Hometown:</small> {{ $user->hometown }}</h5>
                            @endif
                            @if($user->location)
                                <h5><small>Location:</small> {{ $user->location }}</h5>
                            @endif
                            @if($user->hobbies)
                                <h5><small>Hobbies:</small> {{ $user->hobbies }}</h5>
                            @endif
                            @if($user->facebook)
                                <h5><small>Facebook:</small> {{ $user->facebook }}</h5>
                            @endif
                            @if($user->twitter)
                                <h5><small>Twitter:</small> {{ $user->twitter }}</h5>
                            @endif
                            @if($user->pinterest)
                                <h5><small>Pinterest:</small> {{ $user->pinterest }}</h5>
                            @endif
                            @if($user->website)
                                <h5><small>Website:</small> {{ $user->website }}</h5>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Payments <a href="{{ url('account/payments') }}" class="pull-right">Go</a></h3>
                </div>
                <div class="panel-body">
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
                    @if($balance/15 >= 1)
                        <a href="{{ url('accounts/payout') }}" class="btn btn-block btn-info">Request Payout</a>
                    @else
                        <a href="{{ url('accounts/payout') }}" class="btn btn-block btn-info disabled" role="button">Request Payout</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Recent Transactions <a href="{{ url('account/payments') }}" class="pull-right">More</a></h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$transactions->isEmpty())
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>${{ number_format((float)$transaction->amount, 2, '.', '')}}</td>
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
            </div>
        </div>

        <div class="col-xs-12 col-md-6 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Stats <a href="{{ url('account/stats') }}" class="pull-right">Go</a></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>This Week</h3>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Recipes</h5>
                                    <h3>{{ $weekly->total_recipes }}</h3>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Page Views</h5>
                                    <h3>{{ $weekly->page_views }}</h3>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Reviews</h5>
                                    <h3>{{ $weekly->total_reviews }}</h3>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Net-Helpful</h5>
                                    <h3><span class="text-info toggle-popover text-dotted" data-toggle="popover" title="Review Helpfulness" data-content="Helpful: {{ $weekly->review_helpful }} Non-Helpful: {{$weekly->review_nonhelpful }}">{{ $weekly->review_helpful - $weekly->review_nonhelpful }}</span></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <h3>Overall</h3>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Recipes</h5>
                                    <h3>{{ $overall->total_recipes }}</h3>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Page Views</h5>
                                    <h3>{{ $overall->page_views }}</h3>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Reviews</h5>
                                    <h3>{{ $overall->total_reviews }}</h3>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                                    <h5>Net-Helpful</h5>
                                    <h3><span class="text-info toggle-popover text-dotted" data-toggle="popover" title="Review Helpfulness" data-content="Helpful: {{ $overall->review_helpful }} Non-Helpful: {{$overall->review_nonhelpful }}">{{ $overall->review_helpful - $overall->review_nonhelpful }}</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('javascript')
    <script>
        $(function(){
            var msnry = $('#masonry-wrap .row').masonry({
                itemSelector: '.masonry-item'
            });
        });
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('.toggle-popover').popover({
                trigger: 'hover',
                placement: 'top'
            });
        })
    </script>
@stop