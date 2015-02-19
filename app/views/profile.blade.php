<?php $css="profile"; ?>

@include('layout.header')
<div id="profile">
    <div id="profile-wrap" class="clearfix" {{ ViewHelper::tileRecipes($bg_recipes) }}></div>
    <div class="container-fluid ">
        <div class="row">
            <div id="profile-header" class="clearfix col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3 content-top">
                {{ ViewHelper::getBreadcrumbs(null, $user->username.'\'s Profile') }}

                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">
                                <a href="{{ url('profile/'.$user->username) }}"><img class="avatar" src="{{ url(ViewHelper::getUserImage($user->image)) }}" /></a>
                            </div>

                            <div class="col-xs-12 col-sm-8">
                                <h3><a href="{{ url('profile/'.$user->username) }}">{{ $user->username }}</a></h3>
                                <div class="row">
                                    <div id="recipe-stats" class="clearfix">
                                        <div class="col-xs-12">
                                            <h6>Recipe Info</h6>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p>Recipes Created: <span>{{ $recipe_stats['total'] }}</span></p>
                                            <p>Subscribers: <span>{{ $recipe_stats['subscribers'] }}</span></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p>Avg Rating: <span>{{ ViewHelper::addRatingImages($recipe_stats['avg_rating']) }} ({{ $recipe_stats['reviews'] }})</span></p>
                                        </div>
                                    </div>
                                    <div id="review-stats" class="clearfix">
                                        <div class="col-xs-12">
                                            <h6>Review Info</h6>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p>Reviews Given: <span>{{ $review_stats['total'] }}</span></p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <p>Peopled Helped: <span>{{ $review_stats['helpful'] }}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="about-menu" class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="info">
                                    <i class="glyphicon glyphicon-info-sign"></i> {{ $user->website }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="info">
                                    <i class="glyphicon glyphicon-home"></i> {{ $user->hometown }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="info">
                                    <i class="glyphicon glyphicon-map-marker"></i> {{ $user->location }}
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="info">
                                    <i class="glyphicon glyphicon-heart"></i> {{ $user->hobbies }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="about-menu-more" class="clearfix col-xs-12">
                        <i class="glyphicon glyphicon-chevron-down"></i> See More
                    </div>

                    @if($user->id == Auth::id())
                        <div class="col-xs-12">
                            <a id="edit-profile" class="flat-button flat-button-small" href="{{ url('profile/'.$user->username.'/edit') }}">Edit Profile</a>
                        </div>
                    @endif

                    <div class="col-xs-12 col-sm-4">
                        <a class="flat-button flat-button-small flat-button-green" href="{{ url('cookbook/'.$user->username) }}"><span>my</span>Cookbook ({{ $total_cookbook }})</a>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <a class="flat-button flat-button-small flat-button-green" href="{{ url('profile/'.$user->username.'/recipes') }}">Recipes ({{ $recipe_stats['total'] }})</a>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <a class="flat-button flat-button-small flat-button-green" href="{{ url('profile/'.$user->username.'/reviews') }}">Reviews ({{ $review_stats['total'] }})</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

@include('layout.footer')
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