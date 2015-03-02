@include ('admin.layout.header')

<div class="row">
    <div class="col-xs-12">
        <h1>Forum Categories</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach($categorys as $category)
                    <tr data-categoryid="{{ $category->id }}">
                        <td>{{ $category->name }}</td>
                        <td>
                            {{ Form::open(array('url' => Request::url().'/edit/'.$category->id, 'class' => 'edit-category')) }}
                                {{ Form::hidden('category_name') }}
                                <a data-name="{{ $category->name }}" class="btn btn-default category-edit">Edit</a>
                            {{ Form::close() }}
                        </td>
                        <td><a class="btn btn-default category-delete" href="{{ url(Request::url().'/delete/'.$category->id) }}">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ Form::open(array('url' => Request::url(), 'id' => 'create-category')) }}
        <a class="btn btn-primary">Create Category</a>
        {{ Form::hidden('category_name') }}
        {{ Form::close() }}

    </div>
</div>

@include('admin.layout.footer')

<script>
    $("#sortable").sortable();

    $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        var positions = '';
        $('#sortable tr').each(function(index, value){
            var category_id = $(value).data('categoryid');
            positions += category_id + ',';
        });

        $.ajax({
            url: "{{ Request::url() }}/updatePosition",
            data: {orderBy : positions}
        })
    });
</script>
<script>
    $('#create-category a').click(function(){
        var category_name = prompt("Enter New Category Name");

        if(category_name){
            $('#create-category input[name=category_name]').val(category_name);
            $('#create-category').submit();
        }
    })
</script>

<script>
    $('.edit-category a').click(function(){
        var category_name = prompt("Change Category Name", $(this).data('name'));
        var form = $(this).parent();

        if(category_name){
            form.find('input[name=category_name]').val(category_name);
            form.submit();
        }
    })
</script>