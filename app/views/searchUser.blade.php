<?php $css="search"; ?>

@include('layout.header')

<div id="search-bar" class="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($default_bg_recipes) }}></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-md-offset-2 content-top">
                {{ ViewHelper::getBreadcrumbs(null, 'Search') }}
                <span>Search for: </span>
                <a href="{{ url('search/'.$search_text) }}">Recipes</a>
                <a href="{{ url('search/'.$search_text.'/user') }}" class="active">Users</a>
                {{ Form::open(array('url' => 'search/'.$search_text.'/user/')) }}
                <input type="text" name="search_text" value="{{ $search_text }}" placeholder="search for recipes, users" />
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div class="beige-bg">
    <div class="ribbon green-ribbon ribbon-content col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
        <h2>search results</h2>

        <ul class="ribbon-left-menu">
        </ul>
        <ul class="ribbon-right-menu">
        </ul>

    </div>

    <div class="container-fluid">
        <div class="row">
            <div id="search-results" class="col-xs-12" >
                <div class="row">
                    @foreach($users as $user)
                        {{ ViewHelper::addUser($user) }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>


@include('layout.footer')
<script>
    var msnry = $('#search-results .row').masonry({
        itemSelector: '.masonry-item'
    });
</script>