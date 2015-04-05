<?php $title = $topic->name; ?>

@extends('forum.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array('text' => 'Forums Home', 'url' => url('forum'))), $topic->name) }}
@overwrite

@section('header')
    {{ $topic->name }}
@stop

@section('content')
    <div class="col-xs-2">
        <p>
            <a class="btn btn-info" href="{{ url(Request::url().'/create') }}">Create Post</a>
        </p>
    </div>
    <div class="col-xs-10">
        <div class="clearfix text-right">
            {{ $posts->links() }}
        </div>
    </div>

    <div class="col-xs-12">
        <div class="list-group">
            <div class="list-group-item">
                <div class="row">
                    <div class="col-xs-5">
                        <h6 class="list-group-item-heading"><strong>Subject</strong></h6>
                    </div>
                    <div class="col-xs-2">
                        <h6 class="list-group-item-heading"><strong>Author</strong></h6>
                    </div>
                    <div class="col-xs-1">
                        <h6 class="list-group-item-heading text-center"><strong>Replys</strong></h6>
                    </div>
                    <div class="col-xs-1">
                        <h6 class="list-group-item-heading text-center"><strong>Views</strong></h6>
                    </div>
                    <div class="col-xs-2 text-right">
                        <h6 class="list-group-item-heading"><strong>Last Activity</strong></h6>
                    </div>
                </div>
            </div>
            @if(!$posts->isEmpty())
                @foreach($posts as $post)
                    <a href="{{ url('forum/post/'.$post->id) }}" class="list-group-item">
                        <div class="row">
                            <div class="col-xs-5">
                                <h4 class="list-group-item-heading"><strong class="text-success">{{ $post->title }}</strong></h4>
                                <p class="list-group-item-text text-muted"><small>{{ substr(strip_tags($post->text), 0, 150) }}..</small></p>
                            </div>
                            <div class="col-xs-2">
                                <h5 class="list-group-item-heading">{{ $post->author->username }}</h5>
                            </div>
                            <div class="col-xs-1">
                                <h5 class="list-group-item-heading text-center">{{ $post->reply_count }}</h5>
                            </div>
                            <div class="col-xs-1">
                                <h5 class="list-group-item-heading text-center">{{ $post->view_count }}</h5>
                            </div>
                            <div class="col-xs-2">
                                @if($post->activity)
                                    <h5 class="list-group-item-heading text-right"><span class="text-info">{{ $post->activity->author->username }}</h5>
                                @else
                                    <h5 class="list-group-item-heading text-right">{{ $post->author->username }}</h5>
                                @endif
                            </div>
                            <div class="col-xs-1">
                                <h5 class="list-group-item-heading text-left"><span class="text-info">{{ $post->lastActivity() }}</h5>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <h3>There are no current posts in this topic. Be the first to make a post by pressing the Create Post button!</h3>
            @endif
        </div>
    </div>

    <div class="col-xs-2">
        <a class="btn btn-info" href="{{ url(Request::url().'/create') }}">Create Post</a>
    </div>
    <div class="col-xs-10">
        <div class="clearfix text-right nomargin">
            {{ $posts->links() }}
        </div>
    </div>

@stop