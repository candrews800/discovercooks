@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Recipes Needing Review</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date Requested</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recipes as $recipe)
                    <tr>
                        <td><a href="{{ url('recipe/'.$recipe->slug) }}">{{ $recipe->name }}</a></td>
                        <td>{{ $recipe->updated_at->format('m/d/Y') }}</td>
                        <td><a href="approve/{{ $recipe->id }}" class="btn btn-default">Approve</a> <a href="deny/{{ $recipe->id }}" class="btn btn-default">Deny</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')