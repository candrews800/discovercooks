<?php //$title = 'Forums Home'; ?>

@extends('forum.templates.default')

@section('header')
    Forums
@stop

@section('content')
    <div class="col-xs-12">
        @foreach($categorys as $category)
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-uppercase">{{ $category->name }}</h3>
                </div>
                <div class="panel-body panel-body-nopadding">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-xs-7">
                                    <h6 class="list-group-item-heading"><strong>Topic Name</strong></h6>
                                </div>
                                <div class="col-xs-1">
                                    <h6 class="list-group-item-heading text-center"><strong>Posts</strong></h6>
                                </div>
                                <div class="col-xs-1">
                                    <h6 class="list-group-item-heading text-center"><strong>Replys</strong></h6>
                                </div>
                                <div class="col-xs-3">
                                    <h6 class="list-group-item-heading"><strong>Last Activity</strong></h6>
                                </div>
                            </div>
                        </div>
                        @foreach($topics as $topic)
                            @if($category->id == $topic->category_id)
                                <a href="{{ url('forum/topic/'.$topic->id) }}" class="list-group-item">
                                    <div class="row">
                                        <div class="col-xs-7">
                                            <h4 class="list-group-item-heading"><strong class="text-success">{{ $topic->name }}</strong></h4>
                                            <p class="list-group-item-text">{{ $topic->description }}</p>
                                        </div>
                                        <div class="col-xs-1">
                                            <h5 class="list-group-item-heading text-center">{{ $topic->total_posts }}</h5>
                                        </div>
                                        <div class="col-xs-1">
                                            <h5 class="list-group-item-heading text-center">{{ $topic->total_replys }}</h5>
                                        </div>
                                        <div class="col-xs-3">
                                            @if($topic->last_activity)
                                                <h5 class="list-group-item-heading"><span class="text-info">{{ $topic->last_activity->title }}</span></h5>
                                                <p class="list-group-item-text">by <span class="text-info">{{ $topic->last_activity->author->username }}</span>, {{ $topic->last_activity->lastActivity() }} ago</p>
                                            @else
                                                <h5 class="list-group-item-heading">None found.</h5>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop