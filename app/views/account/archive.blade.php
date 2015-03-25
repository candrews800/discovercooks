<?php $active = 'stats'; ?>
@extends('account.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('account'), 'text' => 'My Account'
        ),array(
        'url' => url('account/stats'), 'text' => 'Statistics'
    )), 'Archive') }}
@stop

@section('content')
    <div class="col-xs-12">
        <h1 class="page-header">Weekly Archive</h1>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">Start</th>
                    <th class="text-center">End</th>
                    <th class="text-center">Recipes</th>
                    <th class="text-center">Page Views</th>
                    <th class="text-center">Reviews</th>
                    <th class="text-center">Net Helpful</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">{{ $archives[0]->end }}</td>
                    <td class="text-center text-muted"><em>Current</em></td>
                    <td class="text-center">{{ $current->total_recipes }}</td>
                    <td class="text-center">{{ $current->page_views }}</td>
                    <td class="text-center">{{ $current->total_reviews }}</td>
                    <td class="text-center">{{ $current->review_helpful - $current->review_nonhelpful }}</td>
                </tr>
                @if(!$archives->isEmpty())
                    @foreach($archives as $archive)
                        <tr>
                            <td class="text-center">{{ $archive->start }}</td>
                            <td class="text-center">{{ $archive->end }}</td>
                            <td class="text-center">{{ $archive->total_recipes }}</td>
                            <td class="text-center">{{ $archive->page_views }}</td>
                            <td class="text-center">{{ $archive->total_reviews }}</td>
                            <td class="text-center">{{ $archive->review_helpful - $archive->review_nonhelpful }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        @if($archives->links())
            <p>
                {{ $archives->links() }}
            </p>
        @endif
    </div>
@stop

@section('javascript')

@stop