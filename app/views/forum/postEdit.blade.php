<?php $title = 'Edit Post'; ?>

@extends('forum.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(
    array('text' => 'Forums Home', 'url' => url('forum')),
    array('text' => $topic->name, 'url' => url('forum/topic/'.$topic->id)),
    array('text' => $post->title, 'url' => url('forum/post/'.$post->id))
    ), 'Edit Post') }}
@overwrite

@section('content')

    <div id="add-reply" class="col-xs-12">
        <h4>EDIT POST</h4>
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
            <div class="col-xs-9 col-md-6">
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
                {{ Form::open(array('url' => Request::url(), 'id' => 'reply-form')) }}
                {{ Form::text('title', $post->title, array('class' => 'form-control')) }}
                {{ Form::textarea('text', $post->text, array('id' => 'reply-textarea', 'class' => 'form-control')) }}
                <p id="preview-reply" class="reply-content"></p>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        {{ Form::submit('Submit', array('class' => 'btn btn-lg btn-info')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop