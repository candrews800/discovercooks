<?php $active = 'stats'; ?>
<?php $title = 'My Recipe Statistics'; ?>
@extends('account.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('account'), 'text' => 'My Account'
        ),array(
        'url' => url('account/stats'), 'text' => 'Statistics'
    )), 'Recipes') }}
@stop

@section('content')
    <div class="col-xs-12">
        <h1 class="page-header">Recipe Statistics</h1>
        @if(!$recipes->isEmpty())
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
                @foreach($recipes as $key=>$recipe)
                    <tr>
                        <?php $page = Input::get('page', 1) ?>
                        <td class="text-center">{{ $key + 1 + ($page-1)*25}}</td>
                        <td><a href="{{ url('recipe/'.$recipe->slug) }}" target="_blank">{{ $recipe->name }}</a></td>
                        <td class="text-center">{{ $recipe->page_views }}</td>
                        <td class="text-center">{{ $recipe->subscriber_count }}</td>
                        <td class="text-center">{{ $recipe->overall_rating }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($recipes->links())
                <p>
                    {{ $recipes->links() }}
                </p>
            @endif
        @else
            <p>No recipes found.</p>
        @endif
    </div>
@stop

@section('javascript')

@stop