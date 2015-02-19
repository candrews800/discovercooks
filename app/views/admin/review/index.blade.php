@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Reviews</h1>
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
                <th>Recipe</th>
                <th>Rating</th>
                <th>Text</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reviews as $key=>$review)
                <tr>
                    <td>{{ $key + 1 + max(Input::get('page') - 1 ,0) * 25 }}</td>
                    <td><a href="{{ url('admin/recipes/'.$review->recipe->slug) }}">{{ $review->recipe->name }}</a></td>
                    <td>{{ $review->rating }}</td>
                    <td>{{ $review->text }}</td>
                    <td><a href="{{ url('admin/users/'.$review->user->username) }}">{{ $review->user->username }}</a></td>
                    <td><a href="{{ url('admin/reviews/'.$review->id.'/delete') }}" class="btn btn-danger" onclick="return confirm('Delete Review?')">Delete</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')