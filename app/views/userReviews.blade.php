<?php $css="profile"; ?>

@include('layout.header')
<div id="profile">
    <div id="profile-wrap" class="clearfix" {{ ViewHelper::tileRecipes($bg_recipes) }}></div>
    <div class="container-fluid ">
        <div class="row">
            <div id="profile-header" class="clearfix col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3 content-top">
                {{ ViewHelper::getBreadcrumbs(array(array('url' => URL::to('profile/'.$user->username), 'text' => $user->username.'\'s Profile')), 'Reviews') }}

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
<div class="white-bg">
    <div class="ribbon orange-ribbon ribbon-content col-xs-12 clearfix">
        <img id="ribbon-img" src="{{ url('assets/img/orange-ribbon.png') }}" />
        <h2>my reviews</h2>

        <div class="profile-stats-inline">
        <ul class="ribbon-left-menu hidden-xs">
            <li>Reviews: <span>{{ $review_stats['total'] }}</span></li>
            <li class="divider">•</li>
            <li>Reviews Found Helpful: <span>{{ $review_stats['helpful'] }}</span></li>
        </ul>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            @if($reviews)
                <div id="search-reviews" class="col-xs-12">
                    <div class="row">
                        @foreach($reviews as $review)
                            {{ ViewHelper::addProfileReview($review) }}
                        @endforeach
                    </div>
                </div>

                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                            <button id="load-more-recipes" class="flat-button flat-button-green flat-button-small">Load More Reviews</button>
                        </div>
                    </div>
                </div>
            @else
                <p class="none-found">This User Has Not Given Any Reviews.</p>
            @endif
        </div>

@include('layout.footer')
<script src="{{ url('assets/readmore/readmore.min.js') }}"></script>
<script>
    $(".review-text").readmore({
        embedCSS: false,
        collapsedHeight: 150,
        moreLink: '<a class="more" href="#">Read more</a>',
        lessLink: '<a class="more" href="#">Close</a>'
    });
</script>

<script>
    var recipeCount = $('.review').length;
    var sortBy = "?sort={{ Input::get('sort') }}";
    var dynamicLoad = 0;
    $(function(){
        $('#recipe-count').text(recipeCount);
    });
    $('#load-more-recipes').click(function(event) {
        event.preventDefault();
        var url = "{{ url('profile/'.$user->username.'/loadReviews') }}";
        var loadText = $(this).html();
        $.ajax({
            url: url + '/' + recipeCount+sortBy,
            beforeSend: function () {
                $('#load-more-recipes').html('Loading... <img class="ajax-loader" src="{{ url('assets/img/ajax-loader.gif') }}" />');
            }
        }).done(function (response) {
            if(response == ''){
                $('#load-more-recipes').html('No Reviews Found.');
            }
            else{
                $('#load-more-recipes').html(loadText);

                var loadedHtml = $.parseHTML(response);
                console.log(loadedHtml);
                $.each(loadedHtml, function(){
                    $(this).hide();
                });

                $('#search-reviews').append(loadedHtml);

                $.each(loadedHtml, function(){
                    $(this).fadeIn('slow');
                    $(this).find('.review-text').readmore({
                        embedCSS: false,
                        collapsedHeight: 58,
                        moreLink: '<a class="more" href="#">Read more</a>',
                        lessLink: '<a class="more" href="#">Close</a>'
                    });
                });

                recipeCount = $('.review').length;
                $('#recipe-count').text(recipeCount);
                dynamicLoad++;
            }
        });
    });
</script>
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