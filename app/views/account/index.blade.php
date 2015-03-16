@extends('account.templates.default')

@section('content')

<div class="col-xs-12">
    <div class="current-stats">
        <h3>This Week's Stats: <a href="{{ url('account/archive') }}">Archive</a></h3>
        <p><strong>Recipes:</strong></p>
        <ul>
            <li><strong>Page Views: </strong> <span>{{ $weekly->page_views }}</span></li>
        </ul>
        <p><strong>Reviews:</strong></p>
        <ul>
            <li><strong>Helpful:</strong> {{ $weekly->review_helpful }}</li>
            <li><strong>Non-Helpful:</strong> {{ $weekly->review_nonhelpful }}</li>
            <li><strong>Net-Helpful:</strong> {{ max($weekly->review_helpful - $weekly->review_nonhelpful, 0) }}</li>
        </ul>
    </div>
    <div class="overall-stats">
        <h3>Overall Stats:</h3>
        <p><strong>Recipes:</strong> <a href="{{ url('account/recipes') }}">Details</a></p>
        <ul>
            <li><strong>Total Recipes:</strong> <span>{{ $overall->total_recipes }}</span></li>
            <li><strong>Page Views: </strong> <span>{{ $overall->page_views }}</span></li>
        </ul>
        <p><strong>Reviews:</strong> <a href="{{ url('account/reviews') }}">Details</a></p>
        <ul>
            <li><strong>Total Reviews:</strong> <span>{{ $overall->total_reviews }}</span></li>
            <li><strong>Helpful:</strong> {{ $overall->review_helpful }}</li>
            <li><strong>Non-Helpful:</strong> {{ $overall->review_nonhelpful }}</li>
            <li><strong>Net-Helpful:</strong> {{ max($overall->review_helpful - $overall->review_nonhelpful, 0) }}</li>
        </ul>
    </div>
</div>

@stop

@section('javascript')

@stop