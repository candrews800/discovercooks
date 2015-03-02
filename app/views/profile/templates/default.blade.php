<?php $css="profile"; ?>

@include('layout.header')

<div id="profile">
    <div id="profile-wrap" class="clearfix" {{ ViewHelper::tileRecipes($bg_recipes) }}></div>
    <div class="container-fluid ">
        <div class="row">
            <div id="profile-header" class="clearfix col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3 content-top">
                @yield('breadcrumbs', ViewHelper::getBreadcrumbs(null, $user->username.'\'s Profile', true))
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

@yield('content')

<?php $css="profile"; ?>


@include('layout.footer')

@yield('javascript')