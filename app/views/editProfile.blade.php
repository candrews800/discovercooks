<?php $css="edit-profile"; ?>

@include ('layout.header')

<div class="header-wrap">
    <div id="header-wrap-bg" class="clearfix" {{ ViewHelper::tileRecipes($default_bg_recipes) }}></div>
    <div class="container-fluid">

    <div class="row">
        <div id="edit-profile" class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 content-top">
            {{ ViewHelper::getBreadcrumbs(array(array('url' => URL::to('profile/'.$user->username), 'text' => $user->username.'\'s Profile')), 'Edit') }}
            <div class="row">
                <div class="col-xs-12">
                    <h1>Edit Profile</h1>
                </div>
                {{ Form::open(array('url' => 'profile/'.$user->username.'/edit', 'id' => 'edit-profile-form', 'class' => 'clearfix')) }}
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        @if($user->image)
                        <div class="dropzone" data-width="300" data-removeurl="{{ url('profile/'.$user->username.'/deleteImage') }}" data-image="{{ url('user_images/'.$user->image) }}" data-url="{{ url('profile/'.$user->username.'/editPicture') }}" data-height="300" data-resize="true" style="width: 100%; height: auto">
                        @else
                        <div class="dropzone" data-width="300" data-url="{{ url('profile/'.$user->username.'/editPicture') }}" data-height="300" data-resize="true" style="width: 100%; height: auto">
                        @endif
                            <input type="file" name="image" />
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label"><i class="glyphicon glyphicon-user"></i> display name:</label>
                        @if($errors->first('username'))
                            <span class="input-error">{{ $errors->first('username') }}</span>
                        @endif
                        {{ Form::text('username', $user->username, array('class' => ViewHelper::addClass('invalid', $errors->first('username')))) }}
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label"><i class="glyphicon glyphicon-envelope"></i> email:</label>
                        @if($errors->first('email'))
                            <span class="input-error">{{ $errors->first('email') }}</span>
                        @endif
                        {{ Form::text('email', $user->email, array('class' => ViewHelper::addClass('invalid', $errors->first('email')))) }}
                    </div>
                    <div class="col-xs-12"></div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label optional"><i class="glyphicon glyphicon-home"></i> hometown:</label>
                        @if($errors->first('hometown'))
                            <span class="input-error">{{ $errors->first('hometown') }}</span>
                        @endif
                        {{ Form::text('hometown', $user->hometown, array('class' => ViewHelper::addClass('invalid', $errors->first('hometown')), 'placeholder' => 'New York, NY')) }}
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label optional"><i class="glyphicon glyphicon-map-marker"></i> current location:</label>
                        @if($errors->first('location'))
                            <span class="input-error">{{ $errors->first('location') }}</span>
                        @endif
                        {{ Form::text('location', $user->location, array('class' => ViewHelper::addClass('invalid', $errors->first('location')), 'placeholder' => 'Atlanta, GA')) }}
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label optional"><i class="glyphicon glyphicon-heart"></i> hobbies:</label>
                        @if($errors->first('hobbies'))
                            <span class="input-error">{{ $errors->first('hobbies') }}</span>
                        @endif
                        {{ Form::text('hobbies', $user->hobbies, array('class' => ViewHelper::addClass('invalid', $errors->first('hobbies')), 'placeholder' => 'Cooking, Reading, Running')) }}

                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label optional">facebook:</label>
                        @if($errors->first('facebook'))
                            <span class="input-error">{{ $errors->first('facebook') }}</span>
                        @endif
                        {{ Form::text('facebook', $user->facebook, array('class' => ViewHelper::addClass('invalid', $errors->first('facebook')), 'placeholder' => 'facebook.com/myprofile')) }}
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label optional">twitter:</label>
                        @if($errors->first('twitter'))
                            <span class="input-error">{{ $errors->first('twitter') }}</span>
                        @endif
                        {{ Form::text('twitter', $user->twitter, array('class' => ViewHelper::addClass('invalid', $errors->first('twitter')), 'placeholder' => 'twitter.com/myprofile')) }}
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label optional">pinterest:</label>
                        @if($errors->first('pinterest'))
                            <span class="input-error">{{ $errors->first('pinterest') }}</span>
                        @endif
                        {{ Form::text('pinterest', $user->pinterest, array('class' => ViewHelper::addClass('invalid', $errors->first('pinterest')), 'placeholder' => 'pinterest.com/myprofil')) }}
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="input-label optional"><i class="glyphicon glyphicon-info-sign"></i> website:</label>
                        @if($errors->first('website'))
                            <span class="input-error">{{ $errors->first('website') }}</span>
                        @endif
                        {{ Form::text('website', $user->website, array('class' => ViewHelper::addClass('invalid', $errors->first('website')), 'placeholder' => 'http://mywebsite.com')) }}
                    </div>
                    <div class="col-xs-10 col-xs-offset-1">
                        {{ Form::submit('Update Profile', array('class' => 'flat-button flat-button-green')) }}
                    </div>
                {{ Form::close() }}
                <div class="divider"></div>
                {{ Form::open(array('url' => 'users/settings/password', 'id' => 'change-password-form')) }}
                    <div class="col-xs-12">
                        <h1>Change Password</h1>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        @if(Session::pull('password_reset_success', false))
                            <span class="input-error">Your password has been reset.</span>
                            <br />
                        @endif
                        <label class="input-label">current password:</label>
                        @if($errors->first('old_password'))
                            <span class="input-error">{{ $errors->first('old_password') }}</span>
                        @endif
                        @if(Session::pull('change_password_error', false))
                            <span class="input-error">The password entered does not match your current password.</span>
                        @endif
                        {{ Form::password('old_password', array('class' => ViewHelper::addClass('invalid', $errors->first('old_password')))) }}
                    </div>
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        <label class="input-label">new password:</label>
                        @if($errors->first('new_password'))
                            <span class="input-error">{{ $errors->first('new_password') }}</span>
                        @endif
                        @if(Session::pull('password_match_error', false))
                            <span class="input-error">The new password and confirm password fields do not match.</span>
                        @endif
                        {{ Form::password('new_password', array('class' => ViewHelper::addClass('invalid', $errors->first('new_password')))) }}
                    </div>
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3">
                        <label class="input-label">confirm password:</label>
                        {{ Form::password('confirm_password', array('class' => ViewHelper::addClass('invalid', $errors->first('new_password')))) }}
                    </div>
                    <div class="col-xs-10 col-xs-offset-1">
                        {{ Form::submit('Update Password', array('class' => 'flat-button flat-button-green')) }}
                    </div>
                {{ Form::close() }}
            </div>
        </div>

        </div>
    </div>

@include ('layout.footer')
<script src="{{ url('assets/html5imageupload/js/html5imageupload.min.js') }}"></script>
<link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrapfull.min.css') }}" type="text/css" />
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