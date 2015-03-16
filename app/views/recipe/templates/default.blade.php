<?php $css="single-recipe"; ?>

@include('layout.header')

@yield('content')

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
            <div id="search-results" class="col-xs-12">
                <div class="row">
                    @foreach ($related_recipes as $key=>$related_recipe)
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
                        {{ ViewHelper::addRecipe($related_recipe) }}
                    @endforeach
                </div>
            </div>
        </div>
        @include('layout.back_to_top')
    </div>
</div>

@include('layout.footer')

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

@yield('javascript')