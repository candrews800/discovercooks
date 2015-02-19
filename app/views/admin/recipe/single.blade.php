@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ $recipe->name }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    {{ Form::open(array('url' => 'admin/recipes/'.$recipe->slug.'/edit')) }}
    <div class="col-lg-12">
        <h3 class="page-header">General Information</h3>
    </div>
    <div class="clearfix">
    <div class="col-lg-6">
        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('name')) }}">
            <label>Recipe Title</label>
            @if($errors->first('name'))
                <span class="input-error">{{ $errors->first('name') }}</span>
            @endif
            {{ Form::text('name', $recipe->name, array('class' => 'form-control')) }}
        </div>

        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('url')) }}">
            <label>Recipe Link</label>
            @if($errors->first('url'))
                <span class="input-error">{{ $errors->first('url') }}</span>
            @endif
            {{ Form::text('url', $recipe->url, array('class' => 'form-control')) }}
        </div>

        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('category')) }}">
            <label>Recipe Category</label>
            @if($errors->first('category'))
                <span class="input-error">{{ $errors->first('category') }}</span>
            @endif
            {{ Form::select('category', $categories, $recipe->category, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('description')) }}">
            <label>Description</label>
            @if($errors->first('description'))
                <span class="input-error">{{ $errors->first('description') }}</span>
            @endif
            <textarea id="recipe-description" class="form-control" name="description" onkeyup="textCounter(this,'counter', 300);" rows="5">{{{ $recipe->description }}}</textarea>
            <p id="description-char-left"><span id="counter">300</span> characters left.</p>
        </div>
    </div>
    </div>
    <div class="col-lg-6">
        <div class="row form-group">
            <div class="col-xs-12">
                <label class="input-label" for="recipe-prep">Prep Time*</label>
                @if($errors->first('prep_time'))
                    <span class="input-error">{{ $errors->first('prep_time') }}</span>
                @endif
            </div>
            <div class="col-xs-6">
                {{ Form::text('prep_time', $recipe->prep_time, array('class' => 'form-control')) }}
            </div>
            <div class="col-xs-6">
                {{ Form::select('prep_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->prep_time_type, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row form-group">
            <div class="col-xs-12">
                <label class="input-label" for="recipe-prep">Cook Time*</label>
                @if($errors->first('cook_time'))
                    <span class="input-error">{{ $errors->first('cook_time') }}</span>
                @endif
            </div>
            <div class="col-xs-6">
                {{ Form::text('cook_time', $recipe->cook_time, array('class' => 'form-control')) }}
            </div>
            <div class="col-xs-6">
                {{ Form::select('cook_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->cook_time_type, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="row form-group">
            <div class="col-xs-12">
                <label class="input-label" for="recipe-prep">Total Time*</label>
                @if($errors->first('total_time'))
                    <span class="input-error">{{ $errors->first('total_time') }}</span>
                @endif
            </div>
            <div class="col-xs-6">
                {{ Form::text('total_time', $recipe->total_time, array('class' => 'form-control')) }}
            </div>
            <div class="col-xs-6">
                {{ Form::select('total_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->total_timee_type, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('servings')) }}">
            <label>Servings</label>
            @if($errors->first('servings'))
                <span class="input-error">{{ $errors->first('servings') }}</span>
            @endif
            {{ Form::selectRange('servings', 0, 60, $recipe->servings, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="col-xs-12">
        <label class="input-label" for="recipe-privacy">Privacy*</label>
    </div>
    <div class="col-xs-12">
        <label class="radio-label" for="recipe-public">
            {{ Form::radio('private', '0', true); }}
            Allow this recipe to be visible to others <strong>(Public)</strong>
        </label>
    </div>
    <div class="col-xs-12">
        <label class="radio-label" for="recipe-private">
            {{ Form::radio('private', '1', $recipe->private); }}
            Only I can see this recipe <strong>(Private)</strong>
        </label>
    </div>

    <div class="col-xs-12">
        <h3 class="page-header">Recipe Image</h3>
    </div>

    <div class="col-xs-12">
        @if($recipe->image)
        <div class="dropzone" data-width="1280" data-image="{{ url('recipe_images/'.$recipe->image) }}" data-ajax="false" data-height="720" data-resize="true" style="width: 25%; height: auto">
        @else
        <div class="dropzone" data-width="1280" data-ajax="false" data-height="720" data-resize="true" style="width: 25%; height: auto">
        @endif
            <input type="file" name="recipe_image" value="{{ $recipe->image }}" />
        </div>
    </div>

    <div class="col-lg-12">
        <h3 class="page-header">How To Cook</h3>
    </div>

    <div class="col-xs-6">
        <input id="ingredients" type="hidden" name="ingredients" value="{{ $recipe->ingredients }}" />
        <div class="row">
            <div class="col-xs-12">
                <label class="input-label">Ingredient</label>
                @if($errors->first('ingredients'))
                    <span class="input-error">{{ $errors->first('ingredients') }}</span>
                @endif
            </div>
            <div class="col-xs-5">
                <div class="row">
                    <div class="col-xs-6">
                        <input id="recipe-quantity" class="form-control" type="text" name="recipe-quantity" data-toggle="tooltip" data-placement="bottom" title="Invalid Format" placeholder="3" />
                    </div>
                    <div class="col-xs-6">
                        {{ Form::select('recipe-quantity-type', Recipe::$ingredientSizes, null, array('id' => 'recipe-quantity-type', 'class' => 'form-control')) }}
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                {{ Form::text('recipe-ingredient', null, array('id' => 'recipe-ingredient', 'placeholder' => 'water', 'class' => 'form-control')) }}
            </div>
            <div class="col-xs-1">
                <a id="add-ingredient" class="btn btn-success" href="#"><b class="glyphicon glyphicon-plus"></b></a>
            </div>
        </div>
    </div>

    <div class="col-xs-6">
        <input id="directions" type="hidden" name="directions" value="{{ $recipe->directions }}" />
        <div class="row">
            <div class="col-xs-12">
                <label class="input-label">Directions</label>
                @if($errors->first('directions'))
                    <span class="input-error">{{ $errors->first('directions') }}</span>
                @endif
            </div>
            <div class="col-xs-11">
                <textarea id="recipe-directions" class="form-control" name="recipe-directions" rows="3"></textarea>
            </div>
            <div class="col-xs-1">
                <a id="add-directions" class="btn btn-success" href="#"><b class="glyphicon glyphicon-plus"></b></a>
            </div>
        </div>
    </div>

    <div class="col-xs-6">
        <h2 class="how-to-cook-header text-center page-header">Ingredients</h2>

        <ul id="ingredient-list" class="text-center list-unstyled">
            @if(($ingredients_list = Input::old('ingredients')) || ($ingredients_list = $recipe->ingredients))
                @foreach(explode("<>", $ingredients_list) as $ingredient)
                    <li><span>{{{ $ingredient }}}</span> <a class="ingredient-delete btn btn-xs btn-default" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="ingredient-edit btn btn-xs btn-default" href="#"><i class="glyphicon glyphicon-pencil"></i></a></li>
                @endforeach
            @endif
        </ul>
    </div>

    <div class="col-xs-6">
        <h2 class="how-to-cook-header text-center page-header">Directions</h2>
        <ol id="directions-list" class="text-center">
            @if(($directions_list = Input::old('directions')) || ($directions_list = $recipe->directions))
                @foreach(explode("<>", $directions_list) as $directions)
                    <li><span>{{{ $directions }}}</span> <a class="directions-delete btn btn-xs btn-default" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="directions-edit btn btn-xs btn-default" href="#"><i class="glyphicon glyphicon-pencil"></i></a></li>
                @endforeach
            @endif
        </ol>
    </div>






        <div class="col-xs-12">
            <input id="edit-recipe-button" type="submit" class="btn btn-primary btn-lg" value="Edit Recipe" />
        </div>
    {{ Form::close() }}
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
<style>
    #ingredient-list li, #directions-list li{
        margin-bottom: 10px;
    }
</style>
<script>
    $('.dropzone').html5imageupload();
</script>

<script src="{{ url('assets/js/textCounter.js') }}"></script>
<script src="{{ url('assets/js/addIngredients.js') }}"></script>
<script src="{{ url('assets/js/addDirections.js') }}"></script>