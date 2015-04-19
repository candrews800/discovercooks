<?php $active = 'stats'; ?>
<?php $title = 'Statistics Overview'; ?>
@extends('account.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('account'), 'text' => 'My Account'
    )), 'Statistics') }}
@stop

@section('content')
    <div class="col-xs-12 col-md-6 stats-header">
        <h2 class="page-header">Overall</h2>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Recipes</h5>
                <h3>{{ $overall->total_recipes }}</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Reviews</h5>
                <h3>{{ $overall->total_reviews }}</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Review Images</h5>
                <h3>{{ $overall->review_with_image }}</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Page Views</h5>
                <h3>{{ $overall->page_views }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 stats-header">
        <h2 class="page-header">This Week <a href="{{ Request::url() . '/archive' }}" class="pull-right"><small class="text-info">Archive <i class="glyphicon glyphicon-calendar"></i></small></a></h2>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Recipes</h5>
                <h3>{{ $weekly->total_recipes }}</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Reviews</h5>
                <h3>{{ $weekly->total_reviews }}</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Review Images</h5>
                <h3>{{ $weekly->review_with_image }}</h3>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 text-center">
                <h5>Page Views</h5>
                <h3>{{ $weekly->page_views }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Top Recipes <a href="{{ url('account/stats/recipes') }}" class="pull-right">View All</a></h3>
            </div>
            <div class="panel-body">
                @if(!$top_recipes->isEmpty())
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Recipe</th>
                            <th class="text-center">Page Views</th>
                            <th class="text-center">Subscribers</th>
                            <th class="text-center">Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($top_recipes as $key=>$recipe)
                            <tr>
                                <td class="text-center">{{ $key+1 }}</td>
                                <td><a href="{{ url('recipe/'.$recipe->slug) }}" target="_blank">{{ $recipe->name }}</a></td>
                                <td class="text-center">{{ $recipe->page_views }}</td>
                                <td class="text-center">{{ $recipe->subscriber_count }}</td>
                                <td class="text-center">{{ $recipe->overall_rating }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p><a href="{{ url('account/stats/recipes') }}" class="btn btn-info btn-block">View All</a></p>
                @else
                <p>No recipes found.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Top Reviews <a href="{{ url('account/stats/reviews') }}" class="pull-right">View All</a></h3>
            </div>
            <div class="panel-body">
                @if(!$top_reviews->isEmpty())
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Recipe</th>
                            <th>Review Text</th>
                            <th class="text-center">Rating</th>
                            <th class="text-center">Net-Helpful</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($top_reviews as $key=>$review)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td><a href="{{ url('recipe/'.$review->recipe->slug) }}" target="_blank">{{ $review->recipe->name }}</a></td>
                                <td><span class="text-info toggle-popover text-dotted" data-toggle="popover" data-trigger="focus" title="{{ $review->recipe->name }} Review" data-content="{{ $review->text }}">{{ substr($review->text,0,30) }}</span></td>
                                <td class="text-center">{{ $review->rating }}</td>
                                <td class="text-center"><span class="text-info toggle-popover text-dotted" data-toggle="popover" title="Review Helpfulness" data-content="Helpful: {{ $review->helpful }} Non-Helpful: {{$review->non_helpful }}">{{ $review->helpful - $review->non_helpful }}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <p><a href="{{ url('account/stats/reviews') }}" class="btn btn-info btn-block">View All</a></p>
                @else
                    <p>No reviews found.</p>
                @endif
            </div>
        </div>
    </div>
@stop

@section('javascript')
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