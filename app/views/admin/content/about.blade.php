@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">About Page</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => 'admin/content/about')) }}
        <div class="form-group">
            {{ Form::textarea('text', $about->text, array('class' => 'form-control')) }}
        </div>

            {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
</div>


@include('admin.layout.footer')