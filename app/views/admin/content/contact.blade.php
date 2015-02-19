@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Contact Page</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        {{ Form::open(array('url' => 'admin/content/contact')) }}
        <div class="form-group">
            <label>Contact Email</label>
            {{ Form::email('email', $contact->email, array('class' => 'form-control')) }}
        </div>

        {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
    </div>
</div>


@include('admin.layout.footer')