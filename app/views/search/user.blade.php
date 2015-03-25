<?php $css="search"; ?>

@include('style.layout.header')

<div id="search-bar" class="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($default_bg_recipes) }}></div>
    <div class="container-fluid">
        <div class="row">
            <div id="search-bar-contents" class="col-xs-12 col-md-8 col-md-offset-2 content-top">
                {{ ViewHelper::getNewBreadcrumbs(null, 'Search', true) }}
                <h3>
                    Search for:
                    <a href="{{ url('search/'.$search_text) }}" class="btn btn-link">Recipes</a>
                    <a href="{{ url('search/'.$search_text.'/user') }}" class="btn btn-success">Users</a>
                </h3>
                {{ Form::open(array('url' => 'search/'.$search_text.'/user/')) }}
                <input type="text" name="search_text" class="form-control" value="{{ $search_text }}" placeholder="search for recipes, users" />
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div class="beige-bg">
    <div class="ribbon green-ribbon ribbon-content col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
        <h3>search results</h3>

        <ul class="ribbon-left-menu">
        </ul>
        <ul class="ribbon-right-menu">
        </ul>

    </div>

    <div class="container-fluid clearfix">
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
</div>


@include('style.layout.footer')
<script>
    var msnry = $('#search-results .row').masonry({
        itemSelector: '.masonry-item'
    });
</script>