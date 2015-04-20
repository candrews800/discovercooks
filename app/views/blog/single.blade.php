<?php $title = $post->title; ?>
@extends('blog.template')


@section('breadcrumbs')
    {{
        ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('blog'), 'text' => 'Blog'
        )), $post->title)
     }}
@stop

@section('content')

    <h1>{{ $post->title }}</h1>

    <p class="text-muted"><em>Posted by <a href="{{ url('profile/discovercooks') }}">DiscoverCooks</a> on {{ $post->created_at->format('M d, Y') }}</em></p>

    {{ $post->text }}

    <h3 id="comment">COMMENTS</h3>
    @if($comments->isEmpty())
        <p>
            There are no comments yet for this article.
        </p>
    @else
        @foreach($comments as $key=>$comment)
            <h5>
                <strong><a href="{{ url('profile/'.$comment->user->username) }}">{{ $comment->user->username }}</a></strong> <small>said {{ $comment->shortDate() }} ago</small>
                @if(Auth::user() && Auth::user()->hasRole('Admin'))
                    <a href="{{ url('blog/deleteComment/'.$comment->id) }}" class="pull-right btn btn-danger btn-xs" onClick="return confirm('Delete entry?')">Delete</a>
                @endif
            </h5>
            <p>{{ nl2br(e($comment->text)) }}</p>
            @if($key < sizeof($comments)-1)
                <hr/>
            @endif
        @endforeach
    @endif

    @if(Auth::guest())
        <h3>You must be logged in to comment.</h3>
    @else
        <h3>ADD COMMENT</h3>
        {{ Form::open(array('url' => Request::url())) }}
            {{ Form::textarea('text', null, array('class' => 'form-control', 'rows' => '7', 'required' => 'required')) }}
            {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
        {{ Form::close() }}
    @endif
@stop