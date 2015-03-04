@extends('profile.templates.default')

@section('content')
<div class="beige-bg">
    <div class="ribbon green-ribbon ribbon-content col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
        <h2>my recipes</h2>

        <div class="profile-stats-inline hidden-xs">
        <ul class="ribbon-left-menu">
            <li>Recipes Created: <span>{{ $recipe_stats['total'] }}</span></li>
            <li class="divider">•</li>
            <li>Subscribers: <span>{{ $recipe_stats['subscribers'] }}</span></li>
        </ul>
        <ul class="ribbon-right-menu">
            <li>Avg Rating: <span>{{ $recipe_stats['avg_rating'] }} stars</span></li>
            <li class="divider">•</li>
            <li>Reviews: <span>{{ $recipe_stats['reviews'] }}</span></li>
        </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div id="profile-recipes" class="col-xs-12">
                <div class="row">
                    @if(!$recipes->isEmpty())
                        <div id="search-results" class="col-xs-12 col-lg-7">
                            <div class="row">
                                @foreach($recipes as $recipe)
                                    {{ ViewHelper::addRecipe($recipe,12,4,4,4) }}
                                @endforeach
                            </div>
                        </div>


                        <div class="col-xs-12 col-lg-5 hidden-xs">
                            <div id="recent-reviews" class="clearfix">
                                <h2>recent reviews</h2>
                                @if(!$recent_reviews->isEmpty())
                                @foreach($recent_reviews as $key=>$review)
                                    <div class="recipe-review clearfix">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <a href="{{ url('profile/'.$review->reviewer->username) }}"><img src="{{ url(ViewHelper::getUserImage($review->reviewer->image)) }}" class="image" /></a>
                                            </div>
                                            <div class="col-xs-10">
                                                <p><a href="{{ url('profile/'.$review->reviewer->username) }}">{{ $review->reviewer->username }}</a> reviewed <a href="{{ url('recipe/'.$review->slug) }}">{{ $review->name }}</a></p>
                                                <p class="recipe-review-date">{{ $review->updated_at->format('M d, Y') }}</p>
                                                <p class="review-text">
                                                    "{{ nl2br(e($review->text)) }}"
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if($key < sizeof($recent_reviews) - 1)
                                        <div class="review-divider"></div>
                                    @endif
                                @endforeach
                                @else
                                    <div class="recipe-review clearfix">
                                        <p id="no-recent-reviews">Be the first to review {{ $user->username }}'s recipes!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-2 col-lg-offset-5">
                            <a class="flat-button flat-button-green flat-button-small" href="{{ url('profile/'.$user->username.'/recipes') }}">View All My Recipes</a>
                        </div>
                    @else
                        <p class="none-found">No Recipes Have Been Created By This User Yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="white-bg">
    <div class="ribbon orange-ribbon ribbon-content col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/orange-ribbon.png') }}" />
        <h2>my reviews</h2>

        <div class="profile-stats-inline hidden-xs">
        <ul class="ribbon-left-menu">
            <li>Reviews Given: <span>{{ $review_stats['total'] }}</span></li>
            <li class="divider">•</li>
            <li>People Helped: <span>{{ $review_stats['helpful'] }}</span></li>
        </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div id="search-reviews" class="col-xs-12">
                <div class="row">
                    @foreach($reviews as $review)
                        {{ ViewHelper::addProfileReview($review) }}
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-2 col-lg-offset-5">
                <a class="flat-button flat-button-green flat-button-small" href="{{ url('profile/'.$user->username.'/reviews') }}">View All My Reviews</a>
            </div>
        </div>
        @include('layout.back_to_top')
    </div>
</div>

@stop

@section('javascript')
<script src="{{ url('assets/readmore/readmore.min.js') }}"></script>
<script src="{{ url('assets/js/initReadMore.js') }}"></script>

<script>
    $('#about-menu-more').click(function(){
        var aboutMenu = $('#about-menu');
        if(aboutMenu.is(':visible')){
            $(this).html('<i class="glyphicon glyphicon-chevron-down"></i> See More');
            aboutMenu.slideUp(250);
        }
        else{
            $(this).html('<i class="glyphicon glyphicon-chevron-up"></i> See Less');
            aboutMenu.slideDown(250);
        }
    });
</script>
@stop