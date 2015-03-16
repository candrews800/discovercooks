@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Credit Accounts</h1>
    </div>

    <div class="col-lg-12">
        <p>
            Pay Users based on the following formula:
        </p>
        <p>
            Recipes: Revenue * Recipe Percent * (Users Total Page Views / Total Page Views)
        </p>
        <p>
            Reviews: Revenue * Review Percent * (Users Net Helpful / Total Net Helpful)
        </p>
    </div>

    <div class="col-xs-4">
        {{ Form::open(array('url' => Request::url())) }}
            <div class="form-group">
                <label for="revenue">Revenue</label>
                <input type="text" class="form-control" id="revenue" name="revenue" placeholder="Enter Revenue">
            </div>

            <div class="form-group">
                <label for="page_views">Page Views</label>
                <input type="text" class="form-control" id="page_views" name="page_views" placeholder="Enter Page Views">
            </div>

            <div class="form-group">
                <label for="page_views">Recipe Percentage</label>
                <input type="text" class="form-control" id="page_views" name="recipe_percent" placeholder="Enter Page Views">
            </div>

            <div class="form-group">
                <label for="page_views">Review Percentage</label>
                <input type="text" class="form-control" id="page_views" name="review_percent" placeholder="Enter Page Views">
            </div>

            <input type="submit" class="btn btn-primary" value="Credit Accounts" />
        {{ Form::close() }}
        </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')