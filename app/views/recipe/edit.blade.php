<?php $css="edit-recipe"; ?>

@include('layout.header')
<div class="container-fluid">
    <div class="row">
        <div id="edit-recipe" class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 content-top">
            @if($recipe->id)
                {{ ViewHelper::getBreadcrumbs(array(array('url' => URL::to('category/'.$recipe->category->name), 'text' => $recipe->category->name.' Recipes'),
                    array('url' => URL::to('recipe/'.$recipe->slug), 'text' => $recipe->name.'')), 'Edit') }}
            @else
                {{ ViewHelper::getBreadcrumbs(null, 'New Recipe') }}
            @endif

            <div class="row">
                @if($recipe->id)
                    {{ Form::open(array('url' => 'recipe/'.$recipe->slug.'/edit', 'files' => true)) }}
                @else
                    {{ Form::open(array('url' => 'recipe/new', 'files' => true)) }}
                @endif
                <div class="col-xs-12">
                    <div class="row">
                        <div class="col-xs-12">
                            @if($recipe->image)
                            <div class="dropzone" data-width="1280" data-image="{{ url('recipe_images/'.$recipe->image) }}" data-ajax="false" data-height="720" data-resize="true" style="width: 100%; height: auto">
                            @else
                            <div class="dropzone" data-width="1280" data-ajax="false" data-height="720" data-resize="true" style="width: 100%; height: auto">
                            @endif
                                <input type="file" name="recipe_image" value="{{ $recipe->image }}" />
                            </div>
                        </div>

                        <div class="col-xs-12 clearfix">
                            <h1>Submit Recipe <span>* indicates required field</span></h1>
                        </div>

                        <div class="col-xs-12">
                            <label class="input-label" for="recipe-title">Recipe Title*</label>
                            @if($errors->first('name'))
                                <span class="input-error">{{ $errors->first('name') }}</span>
                            @endif
                            {{ Form::text('name', $recipe->name, array('class' => ViewHelper::addClass('invalid', $errors->first('name')))) }}
                        </div>

                        <div class="col-xs-12">
                            <label class="input-label" for="recipe-description">Description*</label>
                            @if($errors->first('description'))
                                <span class="input-error">{{ $errors->first('description') }}</span>
                            @endif
                            {{ Form::textarea('description', $recipe->description, array('id' => 'recipe-description', 'class' => ViewHelper::addClass('invalid', $errors->first('description')), 'onkeyup' => 'textCounter(this, "counter", 450);')) }}
                            <p id="description-char-left"><span id="counter">450</span> characters left.</p>
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <label class="input-label" for="recipe-link">Related Link</label>
                            @if($errors->first('url'))
                                <span class="input-error">{{ $errors->first('url') }}</span>
                            @endif
                            {{ Form::text('url', $recipe->url, array('class' => ViewHelper::addClass('invalid', $errors->first('url')))) }}
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <label class="input-label" for="recipe-category">Related Category*</label>
                            @if($errors->first('category'))
                                <span class="input-error">{{ $errors->first('category') }}</span>
                            @endif
                            @if($recipe->category)
                                {{ Form::select('category', $categories, $recipe->category->id, array('id' => 'recipe-category', 'class' => ViewHelper::addClass('invalid', $errors->first('prep_time')))) }}
                            @else
                                {{ Form::select('category', $categories, null, array('id' => 'recipe-category', 'class' => ViewHelper::addClass('invalid', $errors->first('prep_time')))) }}
                            @endif

                        </div>
                            <div class="col-xs-12"></div>

                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="input-label" for="recipe-prep">Prep Time*</label>
                                    @if($errors->first('prep_time'))
                                        <span class="input-error">{{ $errors->first('prep_time') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::text('prep_time', $recipe->prep_time, array('class' => ViewHelper::addClass('invalid', $errors->first('prep_time')))) }}
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::select('prep_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->prep_time_type, array('class' => ViewHelper::addClass('invalid', $errors->first('total_time')))) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="input-label" for="recipe-cook">Cook Time*</label>
                                    @if($errors->first('cook_time'))
                                        <span class="input-error">{{ $errors->first('cook_time') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::text('cook_time', $recipe->cook_time, array('class' => ViewHelper::addClass('invalid', $errors->first('cook_time')))) }}
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::select('cook_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->cook_time_type, array('class' => ViewHelper::addClass('invalid', $errors->first('total_time')))) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="input-label" for="recipe-cook">Total Time*</label>
                                    @if($errors->first('total_time'))
                                        <span class="input-error">{{ $errors->first('total_time') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::text('total_time', $recipe->total_time, array('class' => ViewHelper::addClass('invalid', $errors->first('total_time')))) }}
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::select('total_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->total_time_type, array('class' => ViewHelper::addClass('invalid', $errors->first('total_time')))) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label class="input-label" for="recipe-cook">Servings*</label>
                            @if($errors->first('servings'))
                                <span class="input-error">{{ $errors->first('servings') }}</span>
                            @endif
                            {{ Form::selectRange('servings', 0, 60, $recipe->servings, array('class' => ViewHelper::addClass('invalid', $errors->first('servings')))) }}
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

                        <div id="ingredient-header" class="col-xs-12">
                            <input id="ingredients" type="hidden" name="ingredients" value="{{ $recipe->ingredients }}" />
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="input-label">Add Ingredient</label>
                                    @if($errors->first('ingredients'))
                                        <span class="input-error">{{ $errors->first('ingredients') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-5">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input id="recipe-quantity" class="{{ ViewHelper::addClass('invalid', $errors->first('ingredients'))  }}" type="text" name="recipe-quantity" data-toggle="tooltip" data-placement="bottom" title="Invalid Format" placeholder="3" />
                                        </div>
                                        <div class="col-xs-6">
                                            {{ Form::select('recipe-quantity-type', IngredientSizes::getAll(), null, array('id' => 'recipe-quantity-type', 'class' => ViewHelper::addClass('invalid', $errors->first('ingredients')))) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-9 col-sm-5">
                                    {{ Form::text('recipe-ingredient', null, array('id' => 'recipe-ingredient', 'placeholder' => 'water', 'class' => ViewHelper::addClass('invalid', $errors->first('ingredients')))) }}
                                </div>
                                <div class="col-xs-3 col-sm-2">
                                    <a id="add-ingredient" class="flat-button flat-button-green" href="#"><b class="glyphicon glyphicon-plus"></b></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <h2 class="how-to-cook-header">ingredients</h2>
                            <div class="how-to-cook-divider"></div>

                            <ul id="ingredient-list">
                                @if(($ingredients_list = Input::old('ingredients')) || ($ingredients_list = $recipe->ingredients))
                                    @foreach(explode("<>", $ingredients_list) as $ingredient)
                                        <li><span>{{{ $ingredient }}}</span> <a class="ingredient-delete" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="ingredient-edit" href="#"><i class="glyphicon glyphicon-pencil"></i></a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="col-xs-12">
                            <input id="directions" type="hidden" name="directions" value="{{ $recipe->directions }}" />
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="input-label">Add Direction</label>
                                    @if($errors->first('directions'))
                                        <span class="input-error">{{ $errors->first('directions') }}</span>
                                    @endif
                                </div>
                                <div class="col-xs-12 col-sm-10">
                                    <textarea id="recipe-directions" class="{{ ViewHelper::addClass('invalid', $errors->first('directions')) }}" name="recipe-directions"></textarea>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <a id="add-directions" class="flat-button flat-button-green" href="#"><b class="glyphicon glyphicon-plus"></b></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <h2 class="how-to-cook-header">directions</h2>
                            <div class="how-to-cook-divider"></div>
                            <ul id="directions-list">
                                @if(($directions_list = Input::old('directions')) || ($directions_list = $recipe->directions))
                                    @foreach(explode("<>", $directions_list) as $directions)
                                        <li><span>{{{ $directions }}}</span> <a class="directions-delete" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="directions-edit" href="#"><i class="glyphicon glyphicon-pencil"></i></a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="h2header col-xs-12">
                            <h1>rules</h1>
                        </div>

                        <div class="col-xs-12">
                            <p><strong>Duplicate Recipes:</strong> Please check to ensure this recipe has not been created already. We try to keep all recipes on discoverCooks unique.</p>
                            <p><strong>Copyright Recipes:</strong> If you’re getting this recipe from another source, please ensure that only the ingredients and directions are copied. Copying images,
                                descriptions and/or non-essential information to the recipe is illegal.</p>
                        </div>

                        <div class="col-xs-12">
                            <input id="edit-recipe-button" type="submit" class="flat-button" value="Submit Recipe" />
                        </div>
                        {{ Form::close() }}
                    </div>
                    </div>
                </div>
                @include('layout.back_to_top')
            </div>
        </div>


@include('layout.footer')
<script src="{{ url('assets/touchpunch/touchpunch.min.js') }}"></script>

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

<script src="{{ url('assets/js/dropzone.js') }}"></script>
<script src="{{ url('assets/js/textCounter.js') }}"></script>
<script src="{{ url('assets/js/addIngredients.js') }}"></script>
<script src="{{ url('assets/js/addDirections.js') }}"></script>