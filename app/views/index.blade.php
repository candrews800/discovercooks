<?php $css="home"; ?>

@include('layout.header')
<div id="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($recipes) }}></div>
    <div class="container-fluid">
        <div class="row">
            <div id="home-content" class="col-xs-12 col-lg-8 col-lg-offset-2">
                @if(!$featured_recipes->isEmpty())
                <div id="carousel-home" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipes[0]->image)) }}" alt="Picture of {{ $featured_recipes[0]->name }}"></a>

                            <div class="carousel-caption">
                                <h1><a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}">{{ $featured_recipes[0]->name }}</a></h1>
                                <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}"><img class="featured-author-img image" src="{{ url(ViewHelper::getUserImage($featured_recipes[0]->author->image)) }}" /></a>

                                <p class="author">by <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}">{{ $featured_recipes[0]->author->username }}</a></p>
                            </div>
                        </div>
                        <div class="item">
                            <a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipes[0]->image)) }}" alt="Picture of {{ $featured_recipes[0]->name }}"></a>

                            <div class="carousel-caption">
                                <h1><a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}">{{ $featured_recipes[0]->name }}</a></h1>
                                <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}"><img class="featured-author-img image" src="{{ url(ViewHelper::getUserImage($featured_recipes[0]->author->image)) }}" /></a>

                                <p class="author">by <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}">{{ $featured_recipes[0]->author->username }}</a></p>
                            </div>
                        </div>
                        <div class="item">
                            <a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipes[0]->image)) }}" alt="Picture of {{ $featured_recipes[0]->name }}"></a>

                            <div class="carousel-caption">
                                <h1><a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}">{{ $featured_recipes[0]->name }}</a></h1>
                                <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}"><img class="featured-author-img image" src="{{ url(ViewHelper::getUserImage($featured_recipes[0]->author->image)) }}" /></a>

                                <p class="author">by <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}">{{ $featured_recipes[0]->author->username }}</a></p>
                            </div>
                        </div>
                        <div class="item">
                            <a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipes[0]->image)) }}" alt="Picture of {{ $featured_recipes[0]->name }}"></a>

                            <div class="carousel-caption">
                                <h1><a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}">{{ $featured_recipes[0]->name }}</a></h1>
                                <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}"><img class="featured-author-img image" src="{{ url(ViewHelper::getUserImage($featured_recipes[0]->author->image)) }}" /></a>

                                <p class="author">by <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}">{{ $featured_recipes[0]->author->username }}</a></p>
                            </div>
                        </div>
                        <div class="item">
                            <a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipes[0]->image)) }}" alt="Picture of {{ $featured_recipes[0]->name }}"></a>

                            <div class="carousel-caption">
                                <h1><a href="{{ url('recipe/'.$featured_recipes[0]->slug) }}">{{ $featured_recipes[0]->name }}</a></h1>
                                <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}"><img class="featured-author-img image" src="{{ url(ViewHelper::getUserImage($featured_recipes[0]->author->image)) }}" /></a>

                                <p class="author">by <a href="{{ url('profile/'.$featured_recipes[0]->author->username) }}">{{ $featured_recipes[0]->author->username }}</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-home" role="button" data-slide="prev" onclick="$('.carousel').carousel('prev')">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-home" role="button" data-slide="next" onclick="$('.carousel').carousel('next')">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="ribbon green-ribbon col-xs-12">
    <img id="ribbon-img" src="assets/img/green-ribbon.png" />
    <h2>explore</h2>
</div>

<div class="white-bg">
    <div class="container-fluid">
        <div class="row">
            <div id="recipe-categories" class="col-xs-12">
                <div class="row recipe-category">
                    @foreach($categories as $category)
                        @if($category->related_recipe_id != 0)
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                            <a href="{{ url('category/'.$category->name) }}">
                                <img src="{{ url('category_images/'.$category->image) }}" />
                                {{ $category->name }}
                            </a>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ribbon orange-ribbon col-xs-12">
    <img id="ribbon-img" src="assets/img/orange-ribbon.png" />
    <h2>top recipes</h2>
</div>

<div class="beige-bg">
    <div class="container-fluid">
        <div class="row">
            <div id="search-results" class="col-xs-12">
                <div class="row">
                    @foreach($recipes as $recipe)
                        {{ ViewHelper::addRecipe($recipe) }}
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                <button id="load-more-recipes" class="flat-button flat-button-green flat-button-small">Load More Recipes</button>
            </div>

        </div>
        @include('layout.back_to_top')
    </div>
</div>
@include('layout.footer')
<script type="text/javascript" src="{{ url('assets/touchSwipe/jquery.touchSwipe.min.js') }}"></script>

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
    var totalRecipes = {{ $total_recipes }};
    var sortBy = "?sort={{ Input::get('sort') }}";
    var dynamicLoad = 0;
    $(function(){
        $('#recipe-count').text(recipeCount);
    });
    $('#load-more-recipes').click(function(event) {
        event.preventDefault();
        var url = "{{ url('loadRecipes') }}";
        var loadText = $(this).html();

        $.ajax({
            url: url + '/' + recipeCount+sortBy,
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
    $(function() {
        $(".item").swipe( {
            //Generic swipe handler for all directions
            swipeLeft:function() {
                $('.carousel').carousel('next');
            },
            swipeRight: function(){
                $('.carousel').carousel('prev');
            },
            excludedElements: []
        });
    });
</script>