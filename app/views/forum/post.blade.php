<?php $title = $post->title; ?>
<?php $description = $post->text; ?>

@extends('forum.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(
    array('text' => 'Forums Home', 'url' => url('forum')),
    array('text' => $topic->name, 'url' => url('forum/topic/'.$topic->id))
    ), $post->title) }}
@overwrite

@section('header')
    {{ $post->title }}
@stop

@section('content')
    <div id="reply-header" class="clearfix">
        <div class="col-xs-2">
            <p>
                @if($post->locked)
                    <a class="btn btn-info" href="#add-reply" disabled>Locked</a>
                @elseif(Auth::guest())
                    <a href="#" data-toggle="modal" data-target="#guest-login-modal" class="btn btn-info">Add Reply</a>
                @else
                    <a class="btn btn-info" href="#add-reply">Add Reply</a>
                @endif
            </p>



        </div>
        <div class="col-xs-10 text-right">
            {{ $replys->links() }}
        </div>
    </div>
    <div class="col-xs-12">
        <div class="list-group">
            @if(!Input::get('page') || Input::get('page') < 2)
                <div class="list-group-item clearfix">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="row">
                                <div class="col-xs-4">
                                    <img class="img-responsive" src="{{ url(ViewHelper::getUserImage($post->author->image)) }}" />
                                </div>
                                <div class="col-xs-8">
                                    <a href="{{ url('profile/'.$post->author->username) }}" class="author">{{ $post->author->username }}</a>
                                    <p class="post-count">Posts: {{ $post->author->post_count }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <p class="reply-content">{{ nl2br(ForumHelper::convertToHtml(e($post->text))) }}</p>
                            @if($post->created_at != $post->updated_at)
                                <p class="text-muted">
                                    Last edited {{ $post->updated_at->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                        <div class="col-xs-3 text-right">
                            <p>
                                <a id="1" class="reply-number" href="#1">#1</a>
                            </p>
                            <p class="text-muted">
                                {{ $post->shortDate() }}
                            </p>
                            @if(Auth::id() && (!$post->locked || Auth::user()->hasRole('Admin')))
                                <p>
                                    @if($post->author_id == Auth::id() || Auth::user()->hasRole('Admin'))
                                        <a href="{{ Request::url() }}/edit" class="btn btn-sm btn-success">Edit</a>
                                    @endif
                                    <a href="#add-reply" class="btn btn-sm btn-primary">Reply</a>
                                    <a href="#add-reply" class="add-quote btn btn-sm btn-primary"><i class="glyphicon glyphicon-comment"></i></a>
                                </p>
                                <p>
                                    @if(Auth::user()->hasRole('Admin'))
                                        <a href="{{ Request::url() }}/delete" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                                    @endif
                                    @if(Auth::user()->hasRole('Admin'))
                                        @if($post->sticky)
                                            <a href="{{ Request::url() }}/removeSticky" class="btn btn-sm btn-warning">Remove Sticky</a>
                                        @else
                                            <a href="{{ Request::url() }}/addSticky" class="btn btn-sm btn-warning">Make Sticky</a>
                                        @endif
                                        @if($post->locked)
                                            <a href="{{ Request::url() }}/removeLocked" class="btn btn-sm btn-warning">Remove Locked</a>
                                        @else
                                            <a href="{{ Request::url() }}/addLocked" class="btn btn-sm btn-warning">Make Locked</a>
                                        @endif
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
            @if(!$replys->isEmpty())
                @foreach($replys as $reply)
                    <div class="list-group-item clearfix">
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <img class="img-responsive" src="{{ url(ViewHelper::getUserImage($reply->author->image)) }}" />
                                    </div>
                                    <div class="col-xs-8">
                                        <a href="{{ url('profile/'.$reply->author->username) }}" class="author">{{ $reply->author->username }}</a>
                                        <p class="post-count">Posts: {{ $reply->author->post_count }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <p class="reply-content">{{ nl2br(ForumHelper::convertToHtml(e($reply->text))) }}</p>
                                @if($reply->created_at != $reply->updated_at)
                                    <p class="text-muted">
                                        Last edited {{ $reply->updated_at->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                            <span class="anchor" id="{{ $reply->num }}"></span>
                            <div class="col-xs-3 text-right">
                                <p>
                                    <a class="reply-number" href="#{{ $reply->num }}">#{{ $reply->num }}</a>
                                </p>
                                <p class="text-muted">
                                    {{ $reply->shortDate() }}
                                </p>
                                @if(Auth::id() && (!$post->locked || Auth::user()->hasRole('Admin')))
                                    <p>
                                        @if($reply->author_id == Auth::id() || Auth::user()->hasRole('Admin'))
                                            <a href="{{ url('forum/reply/'.$reply->id) }}" class="btn btn-sm btn-success">Edit</a>
                                        @endif
                                        <a href="#add-reply" class="btn btn-sm btn-primary">Reply</a>
                                        <a href="#add-reply" class="add-quote btn btn-sm btn-primary"><i class="glyphicon glyphicon-comment"></i></a>
                                    </p>
                                    <p>
                                        @if(Auth::user()->hasRole('Admin'))
                                            <a href="{{ url('forum/reply/'.$reply->id.'/delete') }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-xs-12 text-right">
        {{ $replys->links() }}
    </div>

    <div id="add-reply" class="col-xs-12">
        @if($post->locked)
            <a class="btn btn-info" href="#add-reply" disabled>Locked</a>
        @elseif(Auth::guest())
            <div class="row">
                <div class="col-xs-12">
                    <a href="#" data-toggle="modal" data-target="#guest-login-modal" class="btn btn-info">Add Reply</a>
                </div>
            </div>
        @else
            <h4>REPLY TO THREAD</h4>
            <div class="row">
                <div class="post-sidebar col-xs-3">
                    <div class="row">
                        <div class="col-xs-4">
                            <img class="img-responsive" src="{{ url(ViewHelper::getUserImage(Auth::user()->image)) }}" />
                        </div>
                        <div class="col-xs-8">
                            <a class="author">{{ Auth::user()->username }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-9 col-md-6">
                    <div class="reply-actionbar">
                        <div class="row">
                            <div class="col-xs-9">
                                <p>
                                    <a id="reply-bold" href="#" class="btn btn-primary"><strong>B</strong></a>
                                    <a id="reply-italic" href="#" class="btn btn-primary"><em>I</em></a>
                                    <a id="reply-underline" href="#" class="btn btn-primary"><u>U</u></a>
                                    <a id="reply-list" href="#" class="btn btn-primary">ul</a>
                                    <a id="reply-list-item" href="#" class="btn btn-primary">li</a>
                                </p>
                            </div>
                            <div class="col-xs-3">
                                <p class="text-right">
                                    <a id="edit-preview" href="#" class="btn btn-success">Preview</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    {{ Form::open(array('url' => Request::url().'/addReply', 'id' => 'reply-form')) }}

                    {{ Form::textarea('text', null, array('id' => 'reply-textarea', 'class' => 'form-control')) }}
                    <p id="preview-reply" class="reply-content"></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            {{ Form::submit('Submit', array('class' => 'btn btn-lg btn-info')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    </div>
@stop