@extends('recipe.templates.default')

@section('content')
<div id="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($related_recipes) }}></div>
    <div class="container-fluid">
        <div class="row">
            <div id="single-recipe" class="col-xs-12 col-lg-8 col-lg-offset-2 content-top">
                {{ ViewHelper::getBreadcrumbs(array(array('url' => URL::to('category/'.$category->name), 'text' => $category->name.' Recipes')), $recipe->name, true) }}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="upper-menu">
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 hidden-xs">
                                    <a href="{{ url('profile/'.$author->username) }}"><img id="author-img" src="{{ url(ViewHelper::getUserImage($author->image)) }}" /></a>
                                </div>

                                <div class="col-xs-12 col-sm-10">
                                    <h1>{{{ $recipe->name }}}</h1>
                                </div>

                                <div class="col-xs-12 col-sm-10">
                                    <p class="recipe-details">
                                    by <a class="author" href="{{ url('profile/'.$author->username) }}">{{{ $author->username }}}</a>
                                    on <span class="date">{{ $recipe->created_at->format('M d, Y') }}</span>
                                    in <a class="category" href="{{ url('category/'.$category->name) }}">{{{ $category->name }}}</a>
                                    </p>
                                </div>
                                <div class="col-xs-12 col-sm-6 hidden-xs">
                                    @if($recipe->url)
                                    <a class="flat-button flat-button-small flat-button-green" href="{{{ $recipe->url }}}">View post on {{ $author->username }}'s site <i class="glyphicon glyphicon-share"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="recipe-info">
                                <div class="col-xs-12 col-md-7 col-lg-8">
                                    <img id="main-image" src="{{ url(ViewHelper::getRecipeImage($recipe->image)) }}" />
                                </div>
                                <div class="col-xs-12 col-md-5 col-lg-4">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="subscriber_count clearfix {{ ViewHelper::addClass('saved', $recipe->isSaved) }}" data-slug="{{ $recipe->slug }}"><i class="heart glyphicon glyphicon-heart"></i><div class="num">{{ $recipe->subscriber_count }}</div></div>
                                                </div>
                                                <div class="col-xs-12">
                                                    <p>
                                                        Overall Rating:
                                                        {{ ViewHelper::addRatingImages($recipe->overall_rating) }}
                                                        <a href="#reviews">(<span>{{ $total_reviews }}</span>)</a>
                                                    </p>
                                                </div>
                                                <div class="col-xs-12">
                                                    @if(isset($user_review->rating))
                                                        <p>
                                                            My Rating:
                                                            {{ ViewHelper::addRatingImages($user_review->rating) }}
                                                            <a href="#reviews">Edit Rating</a>
                                                        </p>
                                                    @else
                                                        <p>
                                                            My Rating:
                                                            {{ ViewHelper::addRatingImages(0) }}
                                                            <a href="#reviews">Add Rating</a>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6 col-lg-12 info">
                                                    <em><i class="glyphicon glyphicon-time"></i> Prep: </em>{{ $recipe->prep_time }}
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-lg-12 info">
                                                    <em><i class="glyphicon glyphicon-time"></i> Cook: </em>{{ $recipe->cook_time }}
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-lg-12 info">
                                                    <em><i class="glyphicon glyphicon-time"></i> Total: </em>{{ $recipe->total_time }}
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-lg-12 info">
                                                    <em><i class="glyphicon glyphicon-cutlery"></i> Servings: </em>{{ $recipe->servings }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="lower-menu">
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="recipe-description">{{{ $recipe->description }}}</p>
                                </div>


                                <div id="ingredients" class="col-xs-12 col-sm-5">
                                    <h3>ingredients</h3>
                                    <div class="menu-wrapper">
                                        <ul>
                                            @if(strpos($recipe->ingredients, '<>'))
                                                @foreach(explode("<>", $recipe->ingredients) as $ingredient)
                                                    <li><span>{{{ $ingredient }}}</span></li>
                                                @endforeach
                                            @else
                                                <li><span>{{{ $recipe->ingredients }}}</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <div id="directions" class="col-xs-12 col-sm-7">
                                    <h3>directions</h3>
                                    <div class="menu-wrapper">
                                        <ol>
                                            @if(strpos($recipe->directions, '<>'))
                                                @foreach(explode("<>", $recipe->directions) as $key => $direction)
                                                    <li>{{ $key + 1 }}. <span>{{{ $direction }}}</span></li>
                                                @endforeach
                                            @else
                                                <li><span>{{{ $recipe->directions }}}</span></li>
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                                @if(Auth::id() == $recipe->author_id)
                                    <div class="col-xs-12">
                                        <a class="flat-button flat-button-small flat-button-green" href="{{ url('recipe/'.$recipe->slug.'/edit') }}">Edit Recipe</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
<script src="{{ url('assets/readmore/readmore.min.js') }}"></script>
<script src="{{ url('assets/js/initReadMore.js') }}"></script>

<script>
    $('#add-remove-recipe').click(function(event){
        event.preventDefault();
        if($(this).hasClass('add-recipe')){
            var url = "{{ url('cookbook/addRecipe/'.$recipe->slug) }}";
            $.ajax({
                url: url,
                beforeSend: function(){
                    $('#add-remove-recipe').html('Saving <img class="ajax-loader" src="{{ url('assets/img/ajax-loader.gif') }}" />');
                }
            }).done(function(){
                $('#add-remove-recipe').html('Saved <i class="glyphicon glyphicon-star"></i>');
                $('#add-remove-recipe').removeClass('add-recipe');
                $('#add-remove-recipe').removeClass('remove-recipe');
            });
        }
        else{
            var url = "{{ url('cookbook/removeRecipe/'.$recipe->slug) }}";
            $.ajax({
                url: url,
                beforeSend: function(){
                    $('#add-remove-recipe').html('Removing <img class="ajax-loader" src="{{ url('assets/img/ajax-loader.gif') }}" />');
                }
            }).done(function(){
                $('#add-remove-recipe').html('Save To <span>my</span>COOKBOOK <i class="glyphicon glyphicon-star-empty"></i>');
                $('#add-remove-recipe').removeClass('remove-recipe');
                $('#add-remove-recipe').addClass('add-recipe');
            });
        }
    });
</script>

<script>
    var reviewCount = {{ sizeof($reviews) }};
    var totalReviews = {{ $total_reviews }};
    $('#load-more-reviews').click(function(event){
        event.preventDefault();
        var url = "{{ url('recipe/'.$recipe->slug.'/getReviews/') }}/" + reviewCount;

        $.ajax(url).done(function(data){
            reviewsToAdd = $.parseHTML(data);
            console.log(reviewsToAdd);
            $("#reviews .review").last().parent().after(reviewsToAdd);
            $.each(reviewsToAdd, function(){
                console.log($(this).find('.review-text').text());
               $(this).find('.review-text').readmore({
                   embedCSS: false,
                   collapsedHeight: 40,
                   moreLink: '<a class="more" href="#">Read more</a>',
                   lessLink: '<a class="more" href="#">Close</a>'
               });
            });
            reviewCount += 6;
            if(reviewCount >= totalReviews){
                $('#load-more-reviews').hide();
            }
        });
    });
</script>

<script>
    $(function(){
        $('.helpful').click(function(){
            var helpful = this;
            var review_author = $(this).parent().find('.review-author').text();
            var url = "{{ url('recipe/'.$recipe->slug.'/reviewer/') }}/" + review_author + "/1";
            $.ajax(url).done(function(){
                $(helpful).addClass('selected');
                $(helpful).parent().find('.non-helpful').removeClass('selected');
            });
        });

        $('.non-helpful').click(function(){
            var nonHelpful = this;
            var review_author = $(this).parent().find('.review-author').text();
            var url = "{{ url('recipe/'.$recipe->slug.'/reviewer/') }}/" + review_author + "/0";
            $.ajax(url).done(function(){
                $(nonHelpful).addClass('selected');
                $(nonHelpful).parent().find('.helpful').removeClass('selected');
            });
        });
    })

</script>
<script>
    $(resizeOuter);
    $(window).resize(resizeOuter);

    function resizeOuter(){
        var x = $('.rating-percent-outer').offset().left;
        var x2 = $('.review-stats .ratings').offset().left;
        var outerWidth = x2-x-15;

        $('.rating-percent-outer').width(outerWidth);
    }
</script>

<script>
    var ratingList = $("#recipe-rating");
    ratingList.find('img').hover(function(){
        var index = $(this).index();
        fillRating(index);
    }, function(){
        var prevRating = $(ratingList).find('input').val();
        fillRating(prevRating);
    });

    ratingList.find('img').click(function(){
        var index = $(this).index();
        $(ratingList).find('input').val(index);
        fillRating(index);
    });

    function fillRating(rating){
        $('#recipe-rating img').each(function(index){
           if(index < rating){
               $(this).attr('src', '{{ url('assets/img/star-100.png') }}');
           }
            else{
               $(this).attr('src', '{{ url('assets/img/star-0.png') }}');
           }
        });
    }
</script>
@stop