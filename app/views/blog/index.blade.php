<?php $title = 'Blog'; ?>
@extends('blog.template')

@section('content')

    @foreach($recent_posts as $key=>$post)
        <h1 class="text-center"><a href="{{ url('blog/'.$post->slug) }}">{{ $post->title }}</a></h1>
        <p class="text-center article-date"><em>Posted by <a href="{{ url('profile/discovercooks') }}">DiscoverCooks</a> on {{ $post->created_at->format('M d, Y') }}</em></p>

        {{ $post->text }}

        <p>
            <a href="{{ url('blog/'.$post->slug) }}#comment">See Comments</a>
        </p>
        @if($key < sizeof($recent_posts)-1)
        <hr />
        @endif
    @endforeach
    <p>
        {{ $recent_posts->links() }}
    </p>

@stop