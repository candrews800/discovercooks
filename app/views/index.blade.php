<?php $title = 'Home'; ?>

<?php $css="home"; ?>

@include('style.layout.header')
@if(!$featured_recipes->isEmpty())
    <div class="container-fluid content-top">
        <div class="row">
            <div class="col-xs-12 col-md-9">
                <div id="main-slider">
                    @foreach($featured_recipes as $key => $featured_recipe)
                        @if($featured_recipe->caption_style==0)
                            <div class="slider-item">
                                <a href="{{ url('recipe/'.$featured_recipe->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipe->image)) }}" alt="Picture of {{ $featured_recipe->name }}"></a>

                                <div class="carousel-caption">
                                    <div class="row">
                                        <div class="hidden-xs hidden-sm col-md-2 col-lg-1">
                                            <a href="{{ url('profile/'.$featured_recipe->author->username) }}"><img class="featured-author-img img-responsive" src="{{ url(ViewHelper::getUserImage($featured_recipe->author->image)) }}" /></a>
                                        </div>
                                        <div class="col-xs-12 col-md-10 col-lg-11">
                                            <h1><a href="{{ url('recipe/'.$featured_recipe->slug) }}">{{ $featured_recipe->name }}</a></h1>
                                            <p class="author">by <a href="{{ url('profile/'.$featured_recipe->author->username) }}">{{ $featured_recipe->author->username }}</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($featured_recipe->caption_style==1)
                            <div class="slider-item">
                                <a href="{{ url('recipe/'.$featured_recipe->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipe->image)) }}" alt="Picture of {{ $featured_recipe->name }}"></a>

                                <div class="caption-style-1">
                                    <h1 class="text-center"><a href="{{ url('recipe/'.$featured_recipe->slug) }}"><strong><em>{{ $featured_recipe->name }}</em></strong></a></h1>
                                    <div class="divider"></div>
                                    <p class="text-center"><strong>{{ $featured_recipe->caption_text }}</strong> <a class="btn btn-success btn-sm" href="{{ url('recipe/'.$featured_recipe->slug) }}">View Recipe</a></p>
                                </div>
                            </div>
                        @elseif($featured_recipe->caption_style==2)
                            <div class="slider-item">
                                <a href="{{ url('recipe/'.$featured_recipe->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipe->image)) }}" alt="Picture of {{ $featured_recipe->name }}"></a>

                                <div class="caption-style-2">
                                    <h1><a href="{{ url('recipe/'.$featured_recipe->slug) }}"><strong>{{ $featured_recipe->name }}</strong></a></h1>
                                    <a class="btn btn-success" href="{{ url('recipe/'.$featured_recipe->slug) }}">View Recipe</a>
                                </div>
                            </div>
                        @elseif($featured_recipe->caption_style==3)
                            <div class="slider-item">
                                <a href="{{ url('recipe/'.$featured_recipe->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipe->image)) }}" alt="Picture of {{ $featured_recipe->name }}"></a>

                                <div class="caption-style-3">
                                    <h1><a href="{{ url('recipe/'.$featured_recipe->slug) }}"><strong>{{ $featured_recipe->name }}</strong></a></h1>
                                    <a class="btn btn-success" href="{{ url('recipe/'.$featured_recipe->slug) }}">View Recipe</a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">FROM THE BLOG</h3>
                    </div>
                    <div class="panel-body">
                        <ul id="latest-posts">
                            @foreach($blog_posts as $post)
                            <li><a href="{{ url('blog/'.$post->slug) }}">{{ $post->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <h4 id="explore-recipes-header">Explore Recipes</h4>
        </div>
        <div class="col-xs-12">
            <div id="explore-recipes">
                @foreach($categories as $key=>$category)
                    <div class="secondary-slider clearfix">
                        <a class="recipe-category" href="{{ url('category/'.$category->name) }}">
                            <img src="{{ url('category_images/'.$category->image) }}" />
                        </a>
                        <p class="text-center"><a href="{{ url('category/'.$category->name) }}">{{ $category->name }}</a></p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<div class="ribbon green-ribbon ribbon-content col-xs-12">
    <img id="ribbon-img" src="assets/img/green-ribbon.png" />
    <h3>top recipes</h3>
</div>

<div class="beige-bg">
    <div class="container-fluid">
        <div class="row">
            <div id="search-results" class="col-xs-12">
                <div class="row">
                    @foreach($recipes as $key=>$recipe)
                        @if($key == 6 || $key== 12 || $key == 18)
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 masonry-item">
                                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- Responsive -->
                                <ins class="adsbygoogle"
                                     style="display:block"
                                     data-ad-client="ca-pub-4150481864914949"
                                     data-ad-slot="4304871710"
                                     data-ad-format="auto"></ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>
                        @endif
                        {{ ViewHelper::addRecipe($recipe) }}
                    @endforeach
                </div>
            </div>

            <div class="col-xs-12 text-center">
                <button id="load-more-recipes" class="btn btn-lg btn-info">Load More Recipes</button>
            </div>
        </div>
    </div>
</div>
@include('style.layout.footer')
<script type="text/javascript" src="{{ url('assets/touchSwipe/jquery.touchSwipe.min.js') }}"></script>

<script>
    $(function(){
        $('#search-results .row').imagesLoaded(function(){
            $('#search-results .row').masonry({
                itemSelector: '.masonry-item'
            });
        });
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
    $(document).ready(function(){
        $('#main-slider').slick({
            centerMode: true,
            centerPadding: '0%',
            slidesToShow: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        centerMode: true,
                        centerPadding: '0%',
                        slidesToShow: 1,
                        infinite: true,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 5000,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        centerMode: true,
                        centerPadding: '0',
                        slidesToShow: 1,
                        arrows: false,
                        autoplay: true,
                        autoplaySpeed: 5000,
                    }
                }
            ]
        });

        $('#explore-recipes').slick({
            infinite: true,
            speed: 300,
            slidesToShow: 9,
            slidesToScroll: 3,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        centerPadding: '15px',
                        arrows: false,
                        slidesToShow: 7
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        arrows: false,
                        centerPadding: '15px',
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 500,
                    settings: {
                        arrows: false,
                        centerPadding: '0',
                        slidesToShow: 3
                    }
                }
            ]
        });

    });
</script>