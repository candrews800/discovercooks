@include ('admin.layout.header')

<div class="row">
    <div class="col-xs-12">
        <h1>Forum Topics</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="sortable">
                @foreach($topics as $topic)
                    <tr data-topicid="{{ $topic->id }}">
                        <td>{{ $topic->name }}</td>
                        <td><span>{{ $topic->description }}</span> <a class="topic-description">Edit Description</span></td>
                        <td>
                            <select class="form-control category-select">
                                @foreach($categorys as $category)
                                    <option value="{{ $category->id }}" <?php if($category->id == $topic->category_id){echo "selected='selected'";}?>>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            {{ Form:: open(array('url' => Request::url().'/edit/'.$topic->id, 'class' => 'edit-topic')) }}
                                {{ Form::hidden('topic_name') }}
                                <a data-name="{{ $topic->name }}" class="btn btn-default topic-edit">Edit</a>
                            {{ Form::close() }}
                        </td>
                        <td><a class="btn btn-default topic-delete" href="{{ url(Request::url().'/delete/'.$topic->id) }}">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ Form::open(array('url' => Request::url(), 'id' => 'create-topic')) }}
        <a class="btn btn-primary">Create Topic</a>
        {{ Form::hidden('topic_name') }}
        {{ Form::close() }}

    </div>
</div>

@include('admin.layout.footer')

<script>
    $("#sortable").sortable();

    $( "#sortable" ).on( "sortupdate", function( event, ui ) {
        var positions = '';
        $('#sortable tr').each(function(index, value){
            var topic_id = $(value).data('topicid');
            positions += topic_id + ',';
        });

        $.ajax({
            url: "{{ Request::url() }}/updatePosition",
            data: {orderBy : positions}
        })
    });
</script>
<script>
    $('#create-topic a').click(function(){
        var topic_name = prompt("Enter New Topic Name");

        if(topic_name){
            $('#create-topic input[name=topic_name]').val(topic_name);
            $('#create-topic').submit();
        }
    })
</script>

<script>
    $('.edit-topic a').click(function(){
        var topic_name = prompt("Change Topic Name", $(this).data('name'));
        var form = $(this).parent();

        if(topic_name){
            form.find('input[name=topic_name]').val(topic_name);
            form.submit();
        }
    })
</script>

<script>
    $(".topic-description").click(function(){
        var topic_id = $(this).parents('tr').data('topicid');
        var topic_description = $(this).parents('tr').find('span').text();

        var topic_description = prompt("Edit Description", topic_description);

        if(topic_description){
            window.location.href = "{{ Request::url() }}/editDescription/" + topic_id + "?description="+topic_description;
        }
    });
</script>

<script>
    $(".category-select").change(function(){
        var topic_id = $(this).parents('tr').data('topicid');
        var category_id = $(this).find('option:selected').val();
        window.location.href = "{{ Request::url() }}/updateCategory/" + topic_id + "?category_id="+category_id;
    });
</script>