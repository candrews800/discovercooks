<?php $css="single-recipe"; ?>

@include('layout.header')

<div id="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($related_recipes) }}></div>
    <div class="container-fluid">
        <div class="row">
            <div id="single-recipe" class="col-xs-12 col-lg-8 col-lg-offset-2 content-top">
                {{ ViewHelper::getBreadcrumbs(array(array('url' => URL::to('category/'.$category->name), 'text' => $category->name.' Recipes')), $recipe->name) }}
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
                                                    @if($user_review->rating)
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


                                <div id="ingredients" class="col-xs-12 col-sm-6">
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
                                <div id="directions" class="col-xs-12 col-sm-6">
                                    <h3>directions</h3>
                                    <div class="menu-wrapper">
                                        <ol>
                                            @if(strpos($recipe->directions, '<>'))
                                                @foreach(explode("<>", $recipe->directions) as $direction)
                                                    <li><span>{{{ $direction }}}</span></li>
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
<div class="white-bg">
    <div class="ribbon orange-ribbon col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/orange-ribbon.png') }}" />
        <h2>reviews</h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div id="reviews" class="col-xs-12">
                <div class="row">
                    <div class="clearfix">
                        @if(!$reviews->isEmpty())
                            <div class="clearfix">
                                <div class="review-header review col-xs-12 col-sm-4">
                                    <h4>
                                        <em>Most Helpful Positive Review</em>
                                    </h4>
                                    <a class="review-author" href="{{ url('profile/'.$positive_review->author->username) }}">{{{ $positive_review->author->username }}}</a>
                                    <div class="ratings">
                                        {{ ViewHelper::addRatingImages($positive_review->rating) }}
                                    </div>

                                    <p class="review-text">
                                        {{ nl2br($positive_review->text) }}
                                        <span class="date">{{ $positive_review->updated_at->format('M j, Y') }}</span>
                                    </p>

                                    @if($positive_review->helpful === 1 || $positive_review->helpful === 0)
                                        <i class="helpful-link helpful glyphicon glyphicon-chevron-up <?php if($positive_review->helpful){echo "selected";}?>" ></i>
                                        <i class="helpful-link non-helpful glyphicon glyphicon-chevron-down <?php if(!$positive_review->helpful){echo "selected";}?>" ></i>
                                    @else
                                        <i class="helpful-link helpful glyphicon glyphicon-chevron-up" ></i>
                                        <i class="helpful-link non-helpful glyphicon glyphicon-chevron-down" ></i>
                                    @endif
                                </div>
                                <div class="review-header review col-xs-12 col-sm-4">
                                    <h4>
                                        <em>Most Helpful Critical Review</em>
                                    </h4>
                                    <a class="review-author" href="{{ url('profile/'.$critical_review->author->username) }}">{{{ $critical_review->author->username }}}</a>
                                    <div class="ratings">
                                        {{ ViewHelper::addRatingImages($critical_review->rating) }}
                                    </div>

                                    <p class="review-text">
                                        {{ nl2br($critical_review->text) }}
                                        <span class="date">{{ $critical_review->updated_at->format('M j, Y') }}</span>
                                    </p>

                                    @if($critical_review->helpful === 1 || $critical_review->helpful === 0)
                                        <i class="helpful-link helpful glyphicon glyphicon-chevron-up <?php if($critical_review->helpful){echo "selected";}?>" ></i>
                                        <i class="helpful-link non-helpful glyphicon glyphicon-chevron-down <?php if(!$critical_review->helpful){echo "selected";}?>" ></i>
                                    @else
                                        <i class="helpful-link helpful glyphicon glyphicon-chevron-up" ></i>
                                        <i class="helpful-link non-helpful glyphicon glyphicon-chevron-down" ></i>
                                    @endif
                                </div>
                                <div class="review-header review-stats col-xs-12 col-sm-4">
                                    <h4>
                                        {{ $total_reviews }} Rating<?php if(sizeof($reviews)>1)echo "s";?>
                                    </h4>
                                    <div class="rating-percent-outer">
                                        <div class="rating-percent-inner" style="width: {{ $review_distribution[5] }}%;"></div>
                                    </div>
                                    <div class="ratings">
                                        {{ ViewHelper::addRatingImages(5) }}
                                    </div>
                                    <div class="rating-percent-outer">
                                        <div class="rating-percent-inner" style="width: {{ $review_distribution[4] }}%;"></div>
                                    </div>
                                    <div class="ratings">
                                        {{ ViewHelper::addRatingImages(4) }}
                                    </div>
                                    <div class="rating-percent-outer">
                                        <div class="rating-percent-inner" style="width: {{ $review_distribution[3] }}%;"></div>
                                    </div>
                                    <div class="ratings">
                                        {{ ViewHelper::addRatingImages(3) }}
                                    </div>
                                    <div class="rating-percent-outer">
                                        <div class="rating-percent-inner" style="width: {{ $review_distribution[2] }}%;"></div>
                                    </div>
                                    <div class="ratings">
                                        {{ ViewHelper::addRatingImages(2) }}
                                    </div>
                                    <div class="rating-percent-outer">
                                        <div class="rating-percent-inner" style="width: {{ $review_distribution[1] }}%;"></div>
                                    </div>
                                    <div class="ratings">
                                        {{ ViewHelper::addRatingImages(1) }}
                                    </div>
                                </div>
                            </div>
                            @foreach($reviews as $key=>$review)
                                @if($key%3 == 0)
                                    <div class="clearfix">
                                        @endif
                                        {{ ViewHelper::addReview($review) }}

                                        @if(($key%3 == 0 && $key > 0) || $key == sizeof($reviews) - 1 )
                                    </div>
                                @endif
                            @endforeach

                            @if($total_reviews > Review::$defaultReviewCount)
                                <div class="col-xs-12">
                                    <a id="load-more-reviews" href="#">load more reviews...</a>
                                </div>

                            @endif

                        @else
                            <div class="review-header review col-xs-12 col-sm-8">
                                <h4>
                                    <em>No reviews found for this recipe.</em>
                                </h4>
                                <p class="review-text">
                                    Did you make this recipe? Be the first to rate it below!
                                </p>
                            </div>
                            <div class="review-header review-stats col-xs-12 col-sm-4">
                                <h4>
                                    0 Ratings
                                </h4>
                                <div class="rating-percent-outer">
                                    <div class="rating-percent-inner" style="width: 0%;"></div>
                                </div>
                                <div class="ratings">
                                    {{ ViewHelper::addRatingImages(5) }}
                                </div>
                                <div class="rating-percent-outer">
                                    <div class="rating-percent-inner" style="width: 0%;"></div>
                                </div>
                                <div class="ratings">
                                    {{ ViewHelper::addRatingImages(4) }}
                                </div>
                                <div class="rating-percent-outer">
                                    <div class="rating-percent-inner" style="width: 0%;"></div>
                                </div>
                                <div class="ratings">
                                    {{ ViewHelper::addRatingImages(3) }}
                                </div>
                                <div class="rating-percent-outer">
                                    <div class="rating-percent-inner" style="width: 0%;"></div>
                                </div>
                                <div class="ratings">
                                    {{ ViewHelper::addRatingImages(2) }}
                                </div>
                                <div class="rating-percent-outer">
                                    <div class="rating-percent-inner" style="width: 0%;"></div>
                                </div>
                                <div class="ratings">
                                    {{ ViewHelper::addRatingImages(1) }}
                                </div>
                            </div>
                        @endif


                        <div id="rate-this-recipe" class="col-xs-12">
                            <h4>
                                Rate This Recipe
                            </h4>
                            @if(Auth::guest())
                                <p class="review-text">
                                    Please <a href="#" data-toggle="modal" data-target="#guest-login-modal">login</a> to rate recipes.
                                </p>
                            @else
                                <div class="row">
                                    <div class="col-xs-12 col-lg-8">
                                        <div class="row">
                                            <div class="col-sm-2 hidden-xs">
                                                <img id="review-avatar" class="image" src="{{ url(ViewHelper::getUserImage(Auth::user()->image)) }}" />
                                            </div>
                                            <div class="col-xs-12 col-sm-10">
                                                {{ Form::open(array('url' => 'recipe/'.$recipe->slug.'/addReview')) }}
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-3">
                                                        <div id="recipe-rating">
                                                            @if($user_review)
                                                                <input type="hidden" name="rating" value="{{{ $user_review->rating }}}" />
                                                            @else
                                                                <input type="hidden" name="rating" value="0" />
                                                            @endif
                                                            {{ ViewHelper::addRatingImages($user_review->rating) }}
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($user_review)
                                                    <textarea id="review-text" name="text" cols="1000" rows="3" placeholder="Have you tried this recipe? What did you think?" required>{{{ $user_review->text }}}</textarea>
                                                @else
                                                    <textarea id="review-text" name="text" cols="1000" rows="3" placeholder="Have you tried this recipe? What did you think?" required>@if($user_review){{{ $user_review->text }}}@endif</textarea>
                                                @endif

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-3 col-sm-offset-9">
                                                        @if($user_review)
                                                            <input id="submit-review" type="submit" class="flat-button flat-button-green flat-button-small" value="Save Review" />
                                                        @else
                                                            <input id="submit-review" type="submit" class="flat-button flat-button-green flat-button-small" value="Save Review" />
                                                        @endif
                                                    </div>
                                                </div>

                                                {{ Form::close() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="related-recipes" class="beige-bg">
    <div class="ribbon green-ribbon col-xs-12">
        <img id="ribbon-img" src="{{ url('assets/img/green-ribbon.png') }}" />
        <h2>related recipes</h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="row" id="search-results">
                    @foreach ($related_recipes as $related_recipe)
                        {{ ViewHelper::addRecipe($related_recipe) }}
                    @endforeach
                </div>
            </div>
        </div>

@include('layout.footer')
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