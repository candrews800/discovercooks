<?php $title = $user->username . '\'s Profile'; ?>

@extends('profile.templates.default')

@section('content')
<div class="beige-bg">
    <div class="ribbon green-ribbon col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
        <h3>my recipes</h3>
    </div>
    <div class="container-fluid">
        <div class="row">
            @if(!$recipes->isEmpty())
                <div id="profile-recipes" class="col-xs-12">
                    <div class="row">
                            <div id="search-results" class="col-xs-12 col-lg-7">
                                <div class="row">
                                    @foreach($recipes as $recipe)
                                        {{ ViewHelper::addRecipe($recipe,12,4,4,4) }}
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-xs-12 col-lg-5 hidden-xs">
                                <div id="recent-reviews" class="clearfix">
                                    <ul class="list-group">
                                        <li class="list-group-item active">
                                            <h4 class="list-group-item-heading">Recent Reviews</h4>
                                        </li>
                                        @if(!$recent_reviews->isEmpty())
                                            @foreach($recent_reviews as $key=>$review)
                                                <li class="list-group-item">
                                                <div class="recipe-review clearfix">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <a href="{{ url('profile/'.$review->reviewer->username) }}"><img src="{{ url(ViewHelper::getUserImage($review->reviewer->image)) }}" class="image" /></a>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <p><a href="{{ url('profile/'.$review->reviewer->username) }}">{{ $review->reviewer->username }}</a> reviewed <a href="{{ url('recipe/'.$review->slug) }}">{{ $review->name }}</a></p>
                                                            <p class="recipe-review-date"><small class="text-muted">{{ $review->updated_at->format('M d, Y') }}</small></p>
                                                            <p class="review-text">
                                                                "{{ nl2br(e($review->text)) }}"
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">
                                                <div class="recipe-review clearfix">
                                                    <p id="no-recent-reviews">Be the first to review {{ $user->username }}'s recipes!</p>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-12 text-center">
                                <a class="btn btn-info btn-lg" href="{{ url('profile/'.$user->username.'/recipes') }}">View All My Recipes ({{$recipe_stats['total']}})</a>
                            </div>
                    </div>
                </div>
            @else
                <p class="none-found">{{ $user->username }} has not created any recipes yet.</p>
            @endif
        </div>
    </div>
</div>

<div class="white-bg">
    <div class="ribbon orange-ribbon col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/orange-ribbon.png') }}" />
        <h3>my reviews</h3>
    </div>
    <div class="container-fluid">
        <div class="row">
            @if(!$reviews->isEmpty())
            <div id="search-reviews" class="col-xs-12">
                <div class="row">
                    @foreach($reviews as $review)
                        {{ ViewHelper::addProfileReview($review) }}
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 text-center">
                <a class="btn btn-lg btn-info" href="{{ url('profile/'.$user->username.'/reviews') }}">View All My Reviews ({{$review_stats['total']}})</a>
            </div>
            @else
                <p class="none-found">{{ $user->username }} has not created any reviews yet.</p>
            @endif
        </div>
    </div>
</div>

@stop

@section('javascript')
<script src="{{ url('assets/readmore/readmore.min.js') }}"></script>
<script src="{{ url('assets/js/initReadMore.js') }}"></script>
@stop