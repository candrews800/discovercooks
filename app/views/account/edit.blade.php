<?php $active = 'edit'; ?>
@extends('account.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getNewBreadcrumbs(array(array(
        'url' => url('account'), 'text' => 'My Account'
    )), 'Edit Profile') }}
@stop

@section('content')
<div class="col-xs-12">
    <h2 class="page-header">Edit Account</h2>
</div>
<div id="masonry-wrap" class="col-xs-12">
    <div class="row">
        <div class="col-xs-12 col-md-6 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Profile</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => Request::url(), 'id' => 'edit-profile-form', 'class' => 'clearfix')) }}
                    <div class="col-xs-12">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('username')) }}">
                            <label>
                                Username*
                                @if($errors->first('username'))
                                    <small class="text-danger">{{ $errors->first('username') }}</small>
                                @endif
                            </label>
                            {{ Form::text('username', $user->username, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('email')) }}">
                            <label>
                                Email*
                                @if($errors->first('username'))
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                @endif
                            </label>
                            {{ Form::email('email', $user->email, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('hometown')) }}">
                            <label>
                                Hometown
                                @if($errors->first('hometown'))
                                    <small class="text-danger">{{ $errors->first('hometown') }}</small>
                                @endif
                            </label>
                            {{ Form::text('hometown', $user->hometown, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('location')) }}">
                            <label>
                                Location
                                @if($errors->first('location'))
                                    <small class="text-danger">{{ $errors->first('location') }}</small>
                                @endif
                            </label>
                            {{ Form::text('location', $user->location, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('hobbies')) }}">
                            <label>
                                Hobbies
                                @if($errors->first('hobbies'))
                                    <small class="text-danger">{{ $errors->first('hobbies') }}</small>
                                @endif
                            </label>
                            {{ Form::text('hobbies', $user->hobbies, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('facebook')) }}">
                            <label>
                                Facebook
                                @if($errors->first('facebook'))
                                    <small class="text-danger">{{ $errors->first('facebook') }}</small>
                                @endif
                            </label>
                            {{ Form::text('facebook', $user->facebook, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('twitter')) }}">
                            <label>
                                Twitter
                                @if($errors->first('twitter'))
                                    <small class="text-danger">{{ $errors->first('twitter') }}</small>
                                @endif
                            </label>
                            {{ Form::text('twitter', $user->twitter, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('pinterest')) }}">
                            <label>
                                Pinterest
                                @if($errors->first('pinterest'))
                                    <small class="text-danger">{{ $errors->first('pinterest') }}</small>
                                @endif
                            </label>
                            {{ Form::text('pinterest', $user->pinterest, array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('website')) }}">
                            <label>
                                Website
                                @if($errors->first('website'))
                                    <small class="text-danger">{{ $errors->first('website') }}</small>
                                @endif
                            </label>
                            {{ Form::text('website', $user->website, array('class' => 'form-control')) }}
                        </div>

                        {{ Form::submit('Update Profile', array('class' => 'btn btn-info btn-block')) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Change Profile Picture</h3>
                </div>
                <div class="panel-body">
                    <div class="col-xs-12 text-center">
                        @if($user->image)
                        <div class="dropzone" data-width="300" data-removeurl="{{ url('profile/'.$user->username.'/deleteImage') }}" data-image="{{ url('user_images/'.$user->image) }}" data-url="{{ url('profile/'.$user->username.'/editPicture') }}" data-height="300" data-resize="true" style="max-width: 300px; width: 100%; height: auto">
                        @else
                        <div class="dropzone" data-width="300" data-url="{{ url('profile/'.$user->username.'/editPicture') }}" data-height="300" data-resize="true" style="max-width: 300px; width: 100%; height: auto">
                        @endif
                            <input type="file" name="image" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6 col-lg-6 masonry-item">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Change Password</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => 'users/settings/password', 'id' => 'change-password-form')) }}
                        @if(Session::pull('password_reset_success', false))
                            <p class="text-info">
                                Your password has been reset.
                            </p>
                        @endif

                        <?php $change_password_error = Session::pull('change_password_error', false); ?>
                        <div class="form-group {{ ViewHelper::addClass('has-error', ($errors->first('old_password') || $change_password_error)) }}">
                            <label>
                                Current Password:
                                @if($errors->first('old_password'))
                                    <small class="text-danger">{{ $errors->first('old_password') }}</small>
                                @elseif($change_password_error)
                                    <small class="text-danger">The password entered does not match your current password.</small>
                                @endif
                            </label>
                            {{ Form::password('old_password', array('class' => 'form-control')) }}
                        </div>

                        <?php $password_match_error = Session::pull('password_match_error', false); ?>
                        <div class="form-group {{ ViewHelper::addClass('has-error', ($errors->first('new_password') || $password_match_error)) }}">
                            <label>
                                New Password:
                                @if($errors->first('new_password'))
                                    <small class="text-danger">{{ $errors->first('new_password') }}</small>
                                @elseif($password_match_error)
                                    <small class="text-danger">The new password and confirm password fields do not match.</small>
                                @endif
                            </label>
                            {{ Form::password('new_password', array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group">
                            <label>Confirm Password:</label>
                            {{ Form::password('confirm_password', array('class' => 'form-control')) }}
                        </div>


                        {{ Form::submit('Update Password', array('class' => 'btn btn-info btn-block')) }}

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')
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

    <script>
        $(function(){
            var msnry = $('#masonry-wrap .row').masonry({
                itemSelector: '.masonry-item'
            });
        });
    </script>
@stop