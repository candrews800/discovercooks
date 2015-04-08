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
            @if(Auth::guest())
                <a class="btn btn-info" data-toggle="modal" data-target="#guest-login-modal">Create Post</a>
            @else
                <a class="btn btn-info" href="{{ url(Request::url().'/create') }}">Create Post</a>
            @endif
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

                                <h4 class="list-group-item-heading">
                                    <strong class="text-success">
                                        {{ $post->title }}
                                        @if($post->sticky)
                                            <small><i class="glyphicon glyphicon-flag"></i></small>
                                        @endif
                                        @if($post->locked)
                                            <small><i class="glyphicon glyphicon-lock"></i></small>
                                        @endif
                                    </strong>
                                </h4>
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
                                    <h5 class="list-group-item-heading text-right"><span class="text-info">{{ $post->activity->author->username }}</span></h5>
                                @else
                                    <h5 class="list-group-item-heading text-right"><span class="text-info">{{ $post->author->username }}</span></h5>
                                @endif
                            </div>
                            <div class="col-xs-1">
                                <h5 class="list-group-item-heading text-left"><span class="text-info">{{ $post->lastActivity() }}</span></h5>
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
        @if(Auth::guest())
        <a class="btn btn-info" data-toggle="modal" data-target="#guest-login-modal">Create Post</a>
        @else
            <a class="btn btn-info" href="{{ url(Request::url().'/create') }}">Create Post</a>
        @endif
    </div>
    <div class="col-xs-10">
        <div class="clearfix text-right nomargin">
            {{ $posts->links() }}
        </div>
    </div>

@stop