@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">User Stats</h1>
    </div>

    <div class="col-lg-12">
        <p>Note: Only showing users with stats.</p>

        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Total Recipes</th>
                    <th>Page Views</th>
                    <th>Total Reviews</th>
                    <th>Helpful</th>
                    <th>Non-Helpful</th>
                    <th>Net-Helpful</th>
                    <th>Weekly Page Views</th>
                    <th>Weekly Helpful</th>
                    <th>Weekly Non-Helpful</th>
                    <th>Weekly Net-Helpful</th>
                </tr>
            </thead>
            <tbody>
            @foreach($stats as $stat)
                <tr>
                    <td>{{ $stat->user->username }}</td>
                    <td>{{ $stat->total_recipes }}</td>
                    <td>{{ $stat->page_views }}</td>
                    <td>{{ $stat->total_reviews }}</td>
                    <td>{{ $stat->review_helpful }}</td>
                    <td>{{ $stat->review_nonhelpful }}</td>
                    <td>{{ $stat->review_helpful - $stat->review_nonhelpful }}</td>
                    <td>{{ $stat->weekly->page_views }}</td>
                    <td>{{ $stat->weekly->review_helpful }}</td>
                    <td>{{ $stat->weekly->review_nonhelpful }}</td>
                    <td>{{ $stat->weekly->review_helpful - $stat->weekly->review_nonhelpful }}</td>
                </tr>
            @endforeach
            {{ $stats->links() }}
            </tbody>
        </table>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')