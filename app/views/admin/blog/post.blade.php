@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Create Blog Post</h1>

        {{ Form::open(array('url' => Request::url())) }}

        <div class="form-group">
            <label>Title</label>
            {{ Form::text('title', $post->title, array('class' => 'form-control')) }}
        </div>
        <div class="form-group">
            <label>Text</label>
            {{ Form::textarea('text', $post->text, array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Edit Blog Post', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}

    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')