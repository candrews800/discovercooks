<?php $css="blog"; ?>

@include ('style.layout.header')
<div class="container-fluid">
    <div class="row">
        <div id="breadcrumbs" class="content-top col-xs-12">
            @yield('breadcrumbs', ViewHelper::getNewBreadcrumbs(null, 'Blog'))
        </div>
        <div class="col-xs-12 col-md-8">
            @yield('content')
            <p class="text-center">
                <a href="#breadcrumbs">
                    <i class="glyphicon glyphicon-menu-up"></i><br/>Back To Top
                </a>
            </p>
        </div>
        <div class="col-xs-12 col-md-4">
            <h4>RECENT POSTS</h4>
            <ul class="list-unstyled">
                @foreach($recent_posts as $post)
                    <li><a href="{{ url('blog/'.$post->slug) }}">{{ $post->title }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-xs-12 col-md-4">
            <h4>ARCHIVE</h4>
            <ul class="list-unstyled">
                @foreach($archive as $period)
                    <li><a href="{{ url('blog/archive/year/'.$period->YEAR.'/month/'.$period->MONTH) }}">{{ $period->MONTHNAME . ' ' . $period->YEAR . ' ('.$period->TOTAL.')' }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@include ('style.layout.footer')