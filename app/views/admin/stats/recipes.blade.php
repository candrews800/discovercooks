@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Recipe Stats</h1>
    </div>

    <div class="col-lg-12">
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Page Views</th>
            </tr>
            </thead>
            <tbody>
            @foreach($recipes as $recipe)
                <tr>
                    <td>{{ $recipe->name }}</td>
                    <td>{{ $recipe->page_views }}</td>
                </tr>
            @endforeach
            {{ $recipes->links() }}
            </tbody>
        </table>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')