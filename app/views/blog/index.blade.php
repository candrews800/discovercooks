<?php $title = 'Blog'; ?>
@extends('blog.template')

@section('content')

    @foreach($recent_posts as $key=>$post)
        <h1><a href="{{ url('blog/'.$post->id) }}">{{ $post->title }}</a></h1>

        {{ nl2br($post->text) }}

        <p>
            <a href="{{ url('blog/'.$post->id) }}#comment">See Comments</a>
        </p>
        @if($key < sizeof($recent_posts)-1)
        <hr />
        @endif
    @endforeach
    <p>
        {{ $recent_posts->links() }}
    </p>

@stop