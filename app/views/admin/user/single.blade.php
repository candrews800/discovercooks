@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Users</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    {{ Form::open(array('url' => 'admin/users/'.$user->username.'/edit')) }}
        <div class="col-lg-6">
            <div class="form-group">
                <label>Username</label>
                {{ Form::text('username', $user->username, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Email</label>
                {{ Form::email('email', $user->email, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Hometown</label>
                {{ Form::text('hometown', $user->hometown, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Location</label>
                {{ Form::text('location', $user->location, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Hobbies</label>
                {{ Form::text('hobbies', $user->hobbies, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Facebook</label>
                {{ Form::url('facebook', $user->facebook, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Email</label>
                {{ Form::url('twitter', $user->twitter, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Pinterest</label>
                {{ Form::url('pinterest', $user->pinterest, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Website</label>
                {{ Form::url('website', $user->website, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                <label>User Image</label>
            </div>
            @if($user->image)
            <div class="dropzone" data-width="300" data-removeurl="{{ url('profile/'.$user->username.'/deleteImage') }}" data-image="{{ url('user_images/'.$user->image) }}" data-ajax="false" data-height="300" data-resize="true" style="width: 300px; height: 300px">
            @else
            <div class="dropzone" data-width="300" data-ajax="false" data-height="300" data-resize="true" style="width: 300px; height: 300px">
            @endif
                <input type="file" name="image" />
            </div>
        </div>

        <div class="col-xs-12">
            <div class="form-group">
                {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
            </div>
        </div>
    {{ Form::close() }}
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')
<script src="{{ url('assets/html5imageupload/js/html5imageupload.min.js') }}"></script>
<link rel="stylesheet" href="{{ url('assets/html5imageupload/css/html5imageupload.css') }}" type="text/css" />
<style>
    .dropzone:after{
        content: '';

    }
    .dropzone{
        background: #bbb url("{{ url('assets/img/camera.png') }}") no-repeat center;
        background-size: 75px;

    }
</style>

<script>
    $('.dropzone').html5imageupload();
</script>