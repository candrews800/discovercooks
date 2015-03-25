<?php $css="category"; ?>

@include('style.layout.header')
<div id="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($recipes) }}></div>
    <div class="container-fluid">
        <div class="row">
            <div id="home-content" class="col-xs-12 col-lg-8 col-lg-offset-2">
                {{ ViewHelper::getBreadcrumbs(null, ucfirst($category->name).' Recipes', true) }}
                @if($category->related_recipe_id != 0)
                <div class="row">
                    <div class="col-xs-12">
                        <div id="carousel-home" class="carousel slide" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <a href="{{ url('recipe/'.$featured_recipe->slug) }}"><img class="featured-recipe-img" src="{{ url(ViewHelper::getRecipeImage($featured_recipe->image)) }}" alt="Picture of {{ $featured_recipe->name }}"></a>

                                    <div class="carousel-caption">
                                        <h1><a href="{{ url('recipe/'.$featured_recipe->slug) }}">{{ $featured_recipe->name }}</a></h1>
                                        <a href="{{ url('profile/'.$featured_recipe->author->username) }}"><img class="featured-author-img image" src="{{ url(ViewHelper::getUserImage($featured_recipe->author->image)) }}" /></a>

                                        <p class="author">by <a href="{{ url('profile/'.$featured_recipe->author->username) }}">{{ $featured_recipe->author->username }}</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="ribbon green-ribbon ribbon-content ribbon-sort col-xs-12">
    <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
    <h3>{{ ucfirst($category->name) }}</h3>

    <ul class="ribbon-left-menu">
        <li>
            <?php if(!$sort){$sort='Highest Rated';} ?>
            <div class="dropdown" style="display: inline-block;">
                <p id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sort By: <span>{{ ucwords($sort) }} <i class="glyphicon glyphicon-triangle-bottom"></i></span></p>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li><a href="?sort=">Highest Rated</a></li>
                    <li><a href="?sort=popularity">Popularity</a></li>
                    <li><a href="?sort=new">New</a></li>
                </ul>
            </div>
        </li>
    </ul>
    <ul class="ribbon-right-menu">
        <li>
            <div class="dropdown" style="display: inline-block;">
                <p id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Category: <span>{{ ucfirst($category->name) }} <i class="glyphicon glyphicon-triangle-bottom"></i></span></p>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                    <li><a href="{{ url('category/all') }}">All</a></li>
                    @foreach($top_categories as $top_category)
                        <li><a href="{{ url('category/'.$top_category->name) }}">{{ $top_category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </li>
    </ul>
</div>
<div class="beige-bg">
    <div class="container-fluid">
        <div class="row">
            <div id="search-results" class="col-xs-12" >
                <div class="row">
                    @foreach($recipes as $key=>$recipe)
                        @if($key == 2 || $key== 6 || $key==8)
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

            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <button id="load-more-recipes" class="btn btn-lg btn-info">Load More Recipes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('style.layout.footer')
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
        var url = "{{ url('category/'.$category->name.'/loadRecipes') }}";
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