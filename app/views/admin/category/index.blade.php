@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Category</h1>

        {{ Form::open(array('url' => 'admin/category/create')) }}
            {{ Form::hidden('name', null, array('id' => 'create-category-hidden')) }}
            <a id="create-category" class="btn btn-success">New</a>
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
                <th>Related Recipes</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $key=>$category)
                <tr>
                    <td>{{ $key + 1 + max(Input::get('page') - 1 ,0) * 25 }}</td>
                    <td><a href="{{ url('admin/category/'.$category->name) }}">{{ $category->name }}</a></td>
                    <td>{{ $category->recipe_count }}</td>
                    <td><a href="{{ url('admin/category/'.$category->name.'/delete') }}" class="btn btn-danger">Delete</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')
<script>
    $('#create-category').click(function(){
        var name =  prompt('New Category Name');
        if(name != null){
            $('#create-category-hidden').val(name);
            $(this).parent().submit();
        }
    });
</script>