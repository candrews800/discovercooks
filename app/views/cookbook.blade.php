<?php $css="profile"; ?>

@include('layout.header')
<div id="profile">
    <div id="profile-wrap" class="clearfix" {{ ViewHelper::tileRecipes($bg_recipes) }}></div>
    <div class="container-fluid ">
        <div class="row">
            <div id="profile-header" class="clearfix col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3 content-top">
                {{ ViewHelper::getBreadcrumbs(array(array('url' => URL::to('profile/'.$user->username), 'text' => $user->username.'\'s Profile')), 'Cookbook') }}

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
    <div class="ribbon green-ribbon ribbon-content ribbon-sort col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
        <h2><span>my</span>Cookbook</h2>

        <ul class="ribbon-left-menu">
            <li>
                <?php if(!$sort){$sort='Highest Rated';} ?>
                <div class="dropdown" style="display: inline-block;">
                    <p id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort By: <span>{{ ucwords($sort) }} <i class="glyphicon glyphicon-triangle-bottom"></i></span></p>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><a href="?sort=&filter={{ Input::get('filter') }}">Highest Rated</a></li>
                        <li><a href="?sort=popularity&filter={{ Input::get('filter') }}">Popularity</a></li>
                        <li><a href="?sort=new&filter={{ Input::get('filter') }}">New</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <ul class="ribbon-right-menu">
            <li>
                <?php if(Input::has('filter')){$filter=Input::get('filter');} else{$filter='All';} ?>
                <div class="dropdown" style="display: inline-block;">
                    <p id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter: <span>{{ ucfirst($filter) }} <i class="glyphicon glyphicon-triangle-bottom"></i></span></p>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><a href="?sort={{Input::get('sort')}}">All</a></li>
                        @foreach($top_categories as $category)
                            <li><a href="?sort={{Input::get('sort')}}&filter={{$category->name}}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="container-fluid">
        <div class="row">
            @if($recipes)
            <div id="search-results" class="col-xs-12">
                <div class="row">
                    @foreach($recipes as $recipe)
                        {{ ViewHelper::addRecipe($recipe) }}
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                        <button id="load-more-recipes" class="flat-button flat-button-green flat-button-small">Load More Recipes</button>
                    </div>
                </div>
            </div>
            @else
                <p class="none-found">No Recipes In This User's Cookbook.</p>
            @endif
    </div>

@include('layout.footer')
<script>
    var msnry = $('#search-results .row').masonry({
        itemSelector: '.masonry-item'
    });

    function addItems(ajaxResponse){
        var loadedHtml = $.parseHTML(ajaxResponse);
        console.log(loadedHtml);

        $('#search-results .row').append(loadedHtml).masonry('appended', loadedHtml);

        recipeCount = $('#search-results .row .search-item').length;
        $('#recipe-count').text(recipeCount);
        dynamicLoad++;
    }
</script>
<script>
    var recipeCount = $('#search-results .row .search-item').length;
    var sortBy = "?sort={{ Input::get('sort') }}";
    var filterBy = "&filter={{ Input::get('filter') }}";
    var dynamicLoad = 0;
    $(function(){
        $('#recipe-count').text(recipeCount);
    });
    $('#load-more-recipes').click(function(event) {
        event.preventDefault();
        var url = "{{ url('cookbook/'.$user->username.'/loadRecipes') }}";
        var loadText = $(this).html();
        $.ajax({
            url: url + '/' + recipeCount+sortBy+filterBy,
            beforeSend: function () {
                $('#load-more-recipes').html('Loading... <img class="ajax-loader" src="{{ url('assets/img/ajax-loader.gif') }}" />');
            }
        }).done(function (response) {
            if(response == ''){
                $('#load-more-recipes').html('No Recipes Found.');
            }
            else{
                $('#load-more-recipes').html(loadText);

                addItems(response);
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