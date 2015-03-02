@extends('content.templates.default')

@section('content')
    {{ ViewHelper::getBreadcrumbs(null, 'Terms and Conditions') }}
    <div class="row">
        <div id="terms-and-conditions" class="col-xs-12">
            <h1>Terms and Conditions</h1>

            {{ nl2br($terms->text) }}
        </div>
    </div>
    @include('layout.back_to_top')
@stop