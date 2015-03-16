@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">All Time Stats</h1>
    </div>

    <div class="col-lg-12">
        <ul>
            <li><strong>Total Recipes:</strong>  {{ $stats->total_recipes }}</li>
            <li><strong>Total Reviews:</strong>  {{ $stats->total_reviews }}</li>
            <li><strong>Page Views:</strong>  {{ $stats->page_views }}</li>
        </ul>

        <ul>
            <li><strong>Recipe Page Views:</strong>  {{ $recipe_page_views }}</li>
        </ul>
        <ul>
            <li><strong>Helpful Reviews:</strong>  {{ $helpful }}</li>
            <li><strong>Non Helpful Reviews:</strong>  {{ $nonhelpful }}</li>
            <li><strong>Net Helpful Reviews:</strong>  {{ $helpful - $nonhelpful }}</li>
        </ul>
    </div>

    <div class="col-lg-12">
        <h1 class="page-header">This Weeks Stats</h1>

        <ul>
            <li><strong>Total Recipes:</strong>  add</li>
            <li><strong>Total Reviews:</strong>  add</li>
            <li><strong>Page Views:</strong>  add</li>
        </ul>

        <ul>
            <li><strong>Recipe Page Views:</strong>  {{ $weekly_recipe_page_views }}</li>
        </ul>
        <ul>
            <li><strong>Helpful Reviews:</strong>  {{ $weekly_helpful }}</li>
            <li><strong>Non Helpful Reviews:</strong>  {{ $weekly_nonhelpful }}</li>
            <li><strong>Net Helpful Reviews:</strong>  {{ $weekly_helpful - $weekly_nonhelpful }}</li>
        </ul>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')