@extends('recipe.templates.default')

@section('content')
<div id="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($related_recipes) }}></div>
    <div class="container-fluid">
        <div class="row">
            <div id="single-recipe" class="col-xs-12 col-lg-8 col-lg-offset-2">
                {{ ViewHelper::getNewBreadcrumbs(array(array('url' => URL::to('profile/'.$author->username), 'text' => $author->username.'\'s Recipes')), $recipe->name) }}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="upper-menu">
                            @if($recipe->reviewed == 0)
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>This recipe can only be seen by you as it is currently under review.</strong><br />
                                    Note: Any edits will move it to the back of the queue.
                                </div>
                            @elseif($recipe->approved == 0)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>We're sorry. This recipe did not pass the review and can only be seen by you.</strong><br />
                                    Please make ensure you are following our recipe guidelines before trying to resubmit.
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-xs-12 col-sm-2 hidden-xs">
                                    <a href="{{ url('profile/'.$author->username) }}"><img id="author-img" class="img-responsive" src="{{ url(ViewHelper::getUserImage($author->image)) }}" /></a>
                                </div>

                                <div class="col-xs-12 col-sm-10">
                                    <h1>{{{ $recipe->name }}}</h1>
                                </div>

                                <div class="col-xs-12 col-sm-10">
                                    <p class="recipe-details">
                                    by <a class="author" href="{{ url('profile/'.$author->username) }}">{{{ $author->username }}}</a>
                                    on <span class="text-muted"><em><small>{{ $recipe->created_at->format('M d, Y') }}</small></em></span>
                                    in <a class="category" href="{{ url('category/'.$category->name) }}">{{{ $category->name }}}</a>
                                    </p>
                                </div>
                                <div class="col-xs-12 col-sm-6 hidden-xs">
                                    @if($recipe->url)
                                    <a class="btn btn-info btn-lg" href="{{{ $recipe->url }}}" target="_blank">View post on {{ $author->username }}'s site <i class="glyphicon glyphicon-share"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="recipe-info">
                                <div class="col-xs-12 col-md-7 col-lg-8">
                                    <img id="main-image" class="img-responsive" src="{{ url(ViewHelper::getRecipeImage($recipe->image)) }}" />
                                </div>
                                <div class="col-xs-12 col-md-5 col-lg-4">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="subscriber_count clearfix {{ ViewHelper::addClass('saved', $recipe->isSaved) }}" data-slug="{{ $recipe->slug }}">
                                                        @if($recipe->isSaved)
                                                            <button class="btn btn-block btn-danger btn-lg">
                                                                Saved
                                                            </button>
                                                        @else
                                                            <button class="btn btn-block btn-success btn-lg">
                                                                Save Recipe
                                                            </button>
                                                        @endif
                                                    </div>
                                                    <p>
                                                        Subscribers: <strong>{{ $recipe->subscriber_count }}</strong>
                                                    </p>
                                                    <p class="clearfix">
                                                        <span class="pull-left">Overall Rating:
                                                        {{ ViewHelper::addRatingImages($recipe->overall_rating) }}</span>
                                                        <a href="#reviews" class="pull-right">(<span>{{ $total_reviews }}</span>)</a>
                                                    </p>
                                                    @if(isset($user_review->rating))
                                                        <p class="clearfix">
                                                        <span class="pull-left">
                                                            My Rating:
                                                            {{ ViewHelper::addRatingImages($user_review->rating) }}</span>
                                                            <a href="#reviews" class="pull-right">Edit Rating</a>
                                                        </p>
                                                    @else
                                                        <p class="clearfix">
                                                        <span class="pull-left">
                                                            My Rating:
                                                            {{ ViewHelper::addRatingImages(0) }}</span>
                                                            <a href="#reviews" class="pull-right">Add Rating</a>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <ul class="list-group">
                                                <li class="list-group-item"><i class="glyphicon glyphicon-time pull-right"></i><strong><small>Prep: </small></strong>{{ $recipe->prep_time }}</li>
                                                <li class="list-group-item"><i class="glyphicon glyphicon-time pull-right"></i><strong><small>Cook: </small></strong>{{ $recipe->cook_time }}</li>
                                                <li class="list-group-item"><i class="glyphicon glyphicon-time pull-right"></i><strong><small>Total: </small></strong>{{ $recipe->total_time }}</li>
                                                <li class="list-group-item"><i class="glyphicon glyphicon-cutlery pull-right"></i><strong><small>Servings: </small></strong>{{ $recipe->servings }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="lower-menu">
                            <div class="row">
                                <div class="col-xs-12 col-md-10 col-md-offset-1">
                                    <p class="recipe-description text-center"><em>{{{ $recipe->description }}}</em></p>
                                </div>


                                <div id="ingredients" class="col-xs-12 col-sm-6 text-center">
                                    <h4>Ingredients</h4>
                                    <div class="menu-wrapper">
                                        <ul>
                                            @if(strpos($recipe->ingredients, '<>'))
                                                @foreach(explode("<>", $recipe->ingredients) as $ingredient)
                                                    <li>{{{ $ingredient }}}</li>
                                                @endforeach
                                            @else
                                                <li>{{{ $recipe->ingredients }}}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div id="directions" class="col-xs-12 col-sm-6">
                                    <h4>Directions</h4>
                                    <div class="menu-wrapper">
                                        <ol>
                                            @if(strpos($recipe->directions, '<>'))
                                                @foreach(explode("<>", $recipe->directions) as $key => $direction)
                                                    <li><span>{{{ $direction }}}</span></li>
                                                @endforeach
                                            @else
                                                <li><span>{{{ $recipe->directions }}}</span></li>
                                            @endif
                                        </ol>
                                    </div>
                                    @if($recipe->note)
                                        <h4>notes</h4>
                                        <p>{{{ $recipe->note }}}</p>
                                    @endif
                                </div>
                                @if(Auth::id() == $recipe->author_id)
                                    <div class="col-xs-12">
                                        <a class="btn btn-info btn-block" href="{{ url('recipe/'.$recipe->slug.'/edit') }}">Edit Recipe</a>
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