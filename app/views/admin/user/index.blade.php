@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Users</h1>

        {{ Form::open(array('url' => 'admin/users/search')) }}
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
                <th>Name</th>
                <th>Email</th>
                <th>Recipes</th>
                <th>Reviews</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $key=>$user)
                <tr>
                    <td>{{ $key + 1 + max(Input::get('page') - 1 ,0) * 25 }}</td>
                    <td><a href="{{ url('admin/users/'.$user->username) }}">{{ $user->username }}</a></td>
                    <td><a href="{{ url('admin/users/'.$user->username) }}">{{ $user->email }}</a></td>
                    <td><a href="{{ url('admin/users/'.$user->username.'/recipes') }}">{{ $user->recipe_count }}</a></td>
                    <td><a href="{{ url('admin/reviews/user/'.$user->username) }}">{{ $user->review_count }}</a></td>
                    <td><a href="{{ url('admin/users/'.$user->username.'/delete') }}" class="btn btn-danger" onclick="return confirm('Delete {{ $user->username }}?')">Delete</a></td>
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