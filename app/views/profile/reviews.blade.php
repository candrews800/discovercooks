@extends('profile.templates.default')

@section('content')
    <div class="white-bg">
        <div class="ribbon orange-ribbon ribbon-content col-xs-12 clearfix">
            <img id="ribbon-img" src="{{ url('assets/img/orange-ribbon.png') }}" />
            <h3>my reviews</h3>

            <div class="profile-stats-inline">
                <ul class="ribbon-left-menu hidden-xs">
                    <li>Reviews: <span>{{ $review_stats['total'] }}</span></li>
                    <li class="divider">•</li>
                    <li>Reviews Found Helpful: <span>{{ $review_stats['helpful'] }}</span></li>
                </ul>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                @if($reviews)
                    <div id="search-reviews" class="col-xs-12">
                        <div class="row">
                            @foreach($reviews as $review)
                                {{ ViewHelper::addProfileReview($review) }}
                            @endforeach
                        </div>
                    </div>

                    <div class="col-xs-12 text-center">
                        <button id="load-more-recipes" class="btn btn-lg btn-info">Load More Reviews</button>
                    </div>
                @else
                    <p class="none-found">This User Has Not Given Any Reviews.</p>
                @endif
            </div>
        </div>
    </div>

@stop

@section('javascript')

    <script src="{{ url('assets/readmore/readmore.min.js') }}"></script>
    <script>
        $(".review-text").readmore({
            embedCSS: false,
            collapsedHeight: 150,
            moreLink: '<a class="more" href="#">Read more</a>',
            lessLink: '<a class="more" href="#">Close</a>'
        });
    </script>

    <script>
        var recipeCount = $('.review').length;
        var sortBy = "?sort={{ Input::get('sort') }}";
        var dynamicLoad = 0;
        $(function(){
            $('#recipe-count').text(recipeCount);
        });
        $('#load-more-recipes').click(function(event) {
            event.preventDefault();
            var url = "{{ url('profile/'.$user->username.'/loadReviews') }}";
            var loadText = $(this).html();
            $.ajax({
                url: url + '/' + recipeCount+sortBy,
                beforeSend: function () {
                    $('#load-more-recipes').html('Loading... <img class="ajax-loader" src="{{ url('assets/img/ajax-loader.gif') }}" />');
                }
            }).done(function (response) {
                if(response == ''){
                    $('#load-more-recipes').html('No Reviews Found.');
                }
                else{
                    $('#load-more-recipes').html(loadText);

                    var loadedHtml = $.parseHTML(response);
                    console.log(loadedHtml);
                    $.each(loadedHtml, function(){
                        $(this).hide();
                    });

                    $('#search-reviews').append(loadedHtml);

                    $.each(loadedHtml, function(){
                        $(this).fadeIn('slow');
                        $(this).find('.review-text').readmore({
                            embedCSS: false,
                            collapsedHeight: 58,
                            moreLink: '<a class="more" href="#">Read more</a>',
                            lessLink: '<a class="more" href="#">Close</a>'
                        });
                    });

                    recipeCount = $('.review').length;
                    $('#recipe-count').text(recipeCount);
                    dynamicLoad++;
                }
            });
        });
    </script>
@stop