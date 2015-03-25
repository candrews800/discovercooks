<?php $css="edit-recipe"; ?>

@include('style.layout.header')
<div class="beige-bg">
    <div class="container-fluid">
        <div class="row">
            <div id="edit-recipe" class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                @if($recipe->id)
                    {{ ViewHelper::getNewBreadcrumbs(array(array('url' => URL::to('profile/'.$author->username), 'text' => $author->username.'\'s Recipes'),
                        array('url' => URL::to('recipe/'.$recipe->slug), 'text' => $recipe->name.'')), 'Edit') }}
                @else
                    {{ ViewHelper::getNewBreadcrumbs(null, 'New Recipe') }}
                @endif
                @if($recipe->id)
                    {{ Form::open(array('url' => 'recipe/'.$recipe->slug.'/edit', 'files' => true)) }}
                @else
                    {{ Form::open(array('url' => 'recipe/new', 'files' => true)) }}
                @endif
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
                        @if($recipe->id)
                        <h3>Edit Recipe <small class="pull-right">* indicates required field</small></h3>
                        @else
                        <h3>Submit Recipe <small class="pull-right">* indicates required field</small></h3>
                        @endif
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('name')) }}">
                            <label for="recipe-title">
                                Recipe Title*
                                @if($errors->first('name'))
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                @endif
                            </label>
                            {{ Form::text('name', $recipe->name, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('description')) }}">
                            <label for="recipe-description">
                                Description*
                                @if($errors->first('description'))
                                    <small class="text-danger">{{ $errors->first('description') }}</small>
                                @endif
                            </label>
                            <small id="description-char-left" class="pull-right text-muted"><span id="counter">450</span> characters left.</small>
                            {{ Form::textarea('description', $recipe->description, array('id' => 'recipe-description', 'rows' => '5', 'class' => 'form-control', 'onkeyup' => 'textCounter(this, "counter", 450);')) }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('url')) }}">
                            <label for="recipe-url">
                                Related Link
                                @if($errors->first('url'))
                                    <small class="text-danger">{{ $errors->first('url') }}</small>
                                @endif
                            </label>
                            {{ Form::text('url', $recipe->url, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('category')) }}">
                            <label for="recipe-url">
                                Related Category*
                                @if($errors->first('category'))
                                    <small class="text-danger">{{ $errors->first('category') }}</small>
                                @endif
                            </label>
                            @if($recipe->category)
                                {{ Form::select('category', $categories, $recipe->category->id, array('id' => 'recipe-category', 'class' => 'form-control')) }}
                            @else
                                {{ Form::select('category', $categories, null, array('id' => 'recipe-category', 'class' => 'form-control')) }}
                            @endif
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('prep_time')) }}">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="recipe-prep_time">
                                        Prep Time*
                                        @if($errors->first('prep_time'))
                                            <small class="text-danger">{{ $errors->first('prep_time') }}</small>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::text('prep_time', $recipe->prep_time, array('class' => 'form-control')) }}
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::select('prep_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->prep_time_type, array('class' => 'form-control')) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('cook_time')) }}">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="recipe-prep_time">
                                        Cook Time*
                                        @if($errors->first('cook_time'))
                                            <small class="text-danger">{{ $errors->first('cook_time') }}</small>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::text('cook_time', $recipe->cook_time, array('class' => 'form-control')) }}
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::select('cook_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->cook_time_type, array('class' => 'form-control')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('total_time')) }}">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="recipe-prep_time">
                                        Total Time*
                                        @if($errors->first('cook_time'))
                                            <small class="text-danger">{{ $errors->first('total_time') }}</small>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::text('total_time', $recipe->total_time, array('class' => 'form-control')) }}
                                </div>
                                <div class="col-xs-6">
                                    {{ Form::select('total_time_type', array('min' => 'Minutes', 'hr' => 'Hours'), $recipe->total_time_type, array('class' => 'form-control')) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('servings')) }}">
                            <label for="recipe-servings">
                                Servings*
                                @if($errors->first('servings'))
                                    <small class="text-danger">{{ $errors->first('servings') }}</small>
                                @endif
                            </label>
                            {{ Form::selectRange('servings', 0, 60, $recipe->servings, array('class' => 'form-control')) }}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <label class="input-label" for="recipe-privacy">Privacy*</label>
                        <div class="radio">
                            <label>
                                {{ Form::radio('private', '0', true) }}
                                Allow this recipe to be visible to others <strong>(Public)</strong>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                {{ Form::radio('private', '1', $recipe->private) }}
                                Only I can see this recipe <strong>(Private)</strong>
                            </label>
                        </div>
                    </div>
                    <div id="ingredient-header" class="col-xs-12">
                        <h3>Ingredients <small class="text-muted">Note: Drag items to reorder.</small></h3>
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('ingredients')) }}">
                            <input id="ingredients" type="hidden" name="ingredients" value="{{ $recipe->ingredients }}" />
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="recipe-ingredients">
                                        Add Ingredient
                                        @if($errors->first('ingredients'))
                                            <small class="text-danger">{{ $errors->first('ingredients') }}</small>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-5">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <input id="recipe-quantity" class="form-control" type="text" name="recipe-quantity" data-toggle="tooltip" data-placement="bottom" title="Invalid Format" placeholder="3" />
                                        </div>
                                        <div class="col-xs-6">
                                            {{ Form::select('recipe-quantity-type', IngredientSizes::getAll(), null, array('id' => 'recipe-quantity-type', 'class' => 'form-control')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-9 col-sm-5">
                                    {{ Form::text('recipe-ingredient', null, array('id' => 'recipe-ingredient', 'placeholder' => 'water', 'class' => 'form-control')) }}
                                </div>
                                <div class="col-xs-3 col-sm-2">
                                    <a id="add-ingredient" class="btn btn-info btn-block" href="#"><i class="glyphicon glyphicon-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <ul id="ingredient-list">
                            @if(($ingredients_list = Input::old('ingredients')) || ($ingredients_list = $recipe->ingredients))
                                @foreach(explode("<>", $ingredients_list) as $ingredient)
                                    <li class="clearfix"><span>{{{ $ingredient }}}</span> <a class="ingredient-delete pull-right btn btn-danger btn-xs" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="ingredient-edit pull-right btn btn-xs btn-warning" href="#"><i class="glyphicon glyphicon-pencil"></i></a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="col-xs-12">
                        <h3>Directions <small class="text-muted">Note: Drag items to reorder.</small></h3>
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('directions')) }}">
                        <input id="directions" type="hidden" name="directions" value="{{ $recipe->directions }}" />
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="recipe-directions">
                                        Add Direction
                                        @if($errors->first('directions'))
                                            <small class="text-danger">{{ $errors->first('directions') }}</small>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-xs-12 col-sm-10">
                                    <textarea id="recipe-directions" class="form-control" name="recipe-directions"></textarea>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <a id="add-directions" class="btn btn-info btn-block" href="#"><b class="glyphicon glyphicon-plus"></b></a>
                                </div>
                            </div>
                        </div>

                        <ul id="directions-list">
                            @if(($directions_list = Input::old('directions')) || ($directions_list = $recipe->directions))
                                @foreach(explode("<>", $directions_list) as $directions)
                                    <li><span>{{{ $directions }}}</span> <a class="directions-delete pull-right btn btn-danger btn-xs" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="directions-edit pull-right btn btn-xs btn-warning" href="#"><i class="glyphicon glyphicon-pencil"></i></a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group {{ ViewHelper::addClass('has-error', $errors->first('note')) }}">
                            <label for="recipe-directions">
                                Additional Notes
                                @if($errors->first('directions'))
                                    <small class="text-danger">{{ $errors->first('note') }}</small>
                                @endif
                            </label>
                            {{ Form::textarea('note', $recipe->note, array('id' => 'recipe-note', 'class' => 'form-control', 'rows' => '3')) }}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <h3>Rules</h3>
                        <p><strong>Duplicate Recipes:</strong> Please check to ensure this recipe has not been created already. We try to keep all recipes on discoverCooks unique.</p>
                        <p><strong>Copyright Recipes:</strong> If you’re getting this recipe from another source, please ensure that only the ingredients and directions are copied. Copying images,
                            descriptions and/or non-essential information to the recipe is illegal.</p>
                    </div>

                    <div class="col-xs-12">
                        <input id="edit-recipe-button" type="submit" class="btn btn-block btn-lg btn-info" value="Submit Recipe" />
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@include('style.layout.footer')
<script src="{{ url('assets/touchpunch/touchpunch.min.js') }}"></script>

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

<script src="{{ url('assets/js/dropzone.js') }}"></script>
<script src="{{ url('assets/js/textCounter.js') }}"></script>
<script src="{{ url('assets/js/addIngredients.js') }}"></script>
<script src="{{ url('assets/js/addDirections.js') }}"></script>