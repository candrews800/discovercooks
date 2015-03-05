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
                    @if($user->website)
                    <div class="col-xs-12 profile-about">
                        <div class="info">
                            <a href="{{ $user->website }}"><i class="glyphicon glyphicon-info-sign"></i> {{ $user->website }}</a>
                        </div>
                    </div>
                    @endif
                    @if($user->hometown || $user->location || $user->hobbies)
                    <div id="about-menu" class="profile-about col-xs-12">
                        <div class="row">
                            @if($user->hometown && $user->location)
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
                            @elseif($user->hometown)
                                <div class="col-xs-12">
                                    <div class="info">
                                        <i class="glyphicon glyphicon-map-marker"></i> {{ $user->location }}
                                    </div>
                                </div>
                            @elseif($user->location)
                                <div class="col-xs-12">
                                    <div class="info">
                                        <i class="glyphicon glyphicon-map-marker"></i> {{ $user->location }}
                                    </div>
                                </div>
                            @endif
                            @if($user->hobbies)
                            <div class="col-xs-12">
                                <div class="info">
                                    <i class="glyphicon glyphicon-heart"></i> {{ $user->hobbies }}
                                </div>
                            </div>
                            @endif
                            @if($user->facebook)
                                <div class="col-xs-12 profile-about">
                                    <div class="info">
                                        <a href="{{ $user->facebook }}"><i class="glyphicon glyphicon-share"></i> Facebook</a>
                                    </div>
                                </div>
                            @endif
                            @if($user->twitter)
                                <div class="col-xs-12 profile-about">
                                    <div class="info">
                                        <a href="{{ $user->twitter }}"><i class="glyphicon glyphicon-share"></i> Twitter</a>
                                    </div>
                                </div>
                            @endif
                            @if($user->pinterest)
                                <div class="col-xs-12 profile-about">
                                    <div class="info">
                                        <a href="{{ $user->pinterest }}"><i class="glyphicon glyphicon-share"></i> Pinterest</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div id="about-menu-more" class="clearfix col-xs-12">
                        <i class="glyphicon glyphicon-chevron-down"></i> See More
                    </div>

                    @endif

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

@yield('javascript')