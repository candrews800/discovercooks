@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Recipes</h1>

        {{ Form::open(array('url' => 'admin/recipes/search')) }}
        <div class="form-group">
            <label>Search</label>
            {{ Form::text('search_text', null, array('class' => 'form-control')) }}
        </div>

        {{ Form::close() }}
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Favorite</th>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Reviews</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recipes as $key=>$recipe)
                <tr>
                    <td>{{ $key + 1 + max(Input::get('page') - 1 ,0) * 25 }}</td>
                    <td><a href="{{ url('admin/recipes/'.$recipe->slug.'/favorite/'.!$recipe->isFavorite) }}" class="btn btn-default {{ ViewHelper::addClass('not-', !$recipe->isFavorite) }}favorite">
                            @if($recipe->isFavorite)
                                <i class="glyphicon glyphicon-star"></i>
                            @else
                                <i class="glyphicon glyphicon-star-empty"></i>
                            @endif
                        </a>
                    </td>
                    <td><a href="{{ url('admin/recipes/'.$recipe->slug) }}">{{ $recipe->name }}</a></td>
                    <td>{{ $recipe->overall_rating }}</td>
                    <td><a href="{{ url('admin/reviews/recipe/'.$recipe->slug) }}">{{ $recipe->review_count }}</a></td>
                    <td><a href="{{ url('admin/recipes/'.$recipe->slug.'/delete') }}" class="btn btn-danger" onclick="return confirm('Delete {{ $recipe->name }}?')">Delete</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $recipes->links() }}
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')