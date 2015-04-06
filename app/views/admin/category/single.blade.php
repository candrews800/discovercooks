@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Category</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-6">
        {{ Form::open(array('url' => 'admin/category/'.$category->name)) }}
            <div class="form-group">
                <label>Category Name</label>
                {{ Form::text('name', $category->name, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                <label>Featured Recipe</label>
                {{ Form::select('related_recipe_id', $related_recipes, $category->related_recipe_id ,array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                <label>Category Image</label>
            </div>
            <div class="form-group">
                @if($category->image)
                <div class="dropzone" data-width="540" data-image="{{ url('category_images/'.$category->image) }}" data-ajax="false" data-height="540" data-resize="true" style="width: 50%; height: auto">
                @else
                <div class="dropzone" data-width="540" data-ajax="false" data-height="540" data-resize="true" style="width: 50%; height: auto">
                @endif
                    <input type="file" name="category_image" value="{{ $category->image }}" />
                </div>
            </div>

            {{ Form::submit('Update Category', array('class' => 'btn btn-primary')) }}

        {{ Form::close() }}
    </div>
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
<style>
    #ingredient-list li, #directions-list li{
        margin-bottom: 10px;
    }
</style>
<script>
    $('.dropzone').html5imageupload();
</script>