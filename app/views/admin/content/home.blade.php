@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Home Page</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Featured Recipes</h3>
            </div>
            <div class="panel-body">
                {{ Form::open(array('url' => 'admin/content/featured', 'class' => 'form-horizontal')) }}
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Main Featured</label>
                        <div class="col-sm-10">
                            {{ Form::select('featured_1', $favorite_recipes_dropdown, $featured_recipes[0]->recipe_id, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Featured 2</label>
                        <div class="col-sm-10">
                            {{ Form::select('featured_2', $favorite_recipes_dropdown, $featured_recipes[1]->recipe_id, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Featured 3</label>
                        <div class="col-sm-10">
                            {{ Form::select('featured_3', $favorite_recipes_dropdown, $featured_recipes[2]->recipe_id, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Featured 4</label>
                        <div class="col-sm-10">
                            {{ Form::select('featured_4', $favorite_recipes_dropdown, $featured_recipes[3]->recipe_id, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Featured 5</label>
                        <div class="col-sm-10">
                            {{ Form::select('featured_5', $favorite_recipes_dropdown, $featured_recipes[4]->recipe_id, array('class' => 'form-control')) }}
                        </div>
                    </div>
                    {{ Form::submit('Update Featured Recipes', array('class' => 'btn btn-primary pull-right')) }}
                {{ Form::close() }}

            </div>
        </div>
    </div>
</div>


@include('admin.layout.footer')