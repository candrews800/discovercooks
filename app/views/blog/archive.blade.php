<?php $title = 'Blog'; ?>
@extends('blog.template')

@section('breadcrumbs')
    {{
        ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('blog'), 'text' => 'Blog'
        )), $recent_posts[0]->created_at->format('F Y').' Archive')
     }}
@stop

@section('content')

    <h1 class="page-header">{{ $recent_posts[0]->created_at->format('F Y') }} Posts</h1>

    @foreach($recent_posts as $key=>$post)
        <h1><a href="{{ url('blog/'.$post->id) }}">{{ $post->title }}</a></h1>
        <p>
            {{ nl2br($post->text) }}
        </p>
        <p>
            <a href="{{ url('blog/'.$post->id) }}#comment">See Comments</a>
        </p>
        @if($key < sizeof($recent_posts)-1)
            <hr />
        @endif
    @endforeach
@stop