<?php $active = 'stats'; ?>
@extends('account.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('account'), 'text' => 'My Account'
        ),array(
        'url' => url('account/stats'), 'text' => 'Statistics'
    )), 'Reviews') }}
@stop



@section('content')
    <div class="col-xs-12">
        <h1 class="page-header">Review Statistics</h1>
            @if(!$reviews->isEmpty())
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
                    @foreach($reviews as $key=>$review)
                        <tr>
                            <?php $page = Input::get('page', 1) ?>
                            <td class="text-center">{{ $key + 1 + ($page-1)*25}}</td>
                            <td><a href="{{ url('recipe/'.$review->recipe->slug) }}" target="_blank">{{ $review->recipe->name }}</a></td>
                            <td>{{ nl2br(e($review->text)) }}</td>
                            <td class="text-center">{{ $review->rating }}</td>
                            <td class="text-center"><span class="text-info toggle-popover text-dotted" data-toggle="popover" title="Review Helpfulness" data-content="Helpful: {{ $review->helpful }} Non-Helpful: {{$review->non_helpful }}">{{ $review->helpful - $review->non_helpful }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($reviews->links())
                    <p>
                        {{ $reviews->links() }}
                    </p>
                @endif
            @else
            <p>No reviews found.</p>
        @endif
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