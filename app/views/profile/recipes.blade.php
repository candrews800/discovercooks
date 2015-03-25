@extends('profile.templates.default')

@section('content')
    <div class="beige-bg">
        <div class="ribbon green-ribbon ribbon-content ribbon-sort col-xs-12">
            <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
            <h3>my recipes</h3>

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
                    <div class="col-xs-12 text-center">
                        <button id="load-more-recipes" class="btn btn-lg btn-info">Load More Recipes</button>
                    </div>
                @else
                    <p class="none-found">No Recipes In This User's Cookbook.</p>
                @endif
            </div>
        </div>
    </div>

@stop

@section('javascript')
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
        var totalRecipes = {{ $recipe_stats['total'] }};
        var sortBy = "?sort={{ Input::get('sort') }}";
        var filterBy = "&filter={{ Input::get('filter') }}";
        var dynamicLoad = 0;
        $(function(){
            $('#recipe-count').text(recipeCount);
        });
        $('#load-more-recipes').click(function(event) {
            event.preventDefault();
            var url = "{{ url('profile/'.$user->username.'/loadRecipes') }}";
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
@stop