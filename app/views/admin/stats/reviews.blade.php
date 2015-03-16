@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Review Stats</h1>
    </div>

    <div class="col-lg-12">
        <table class="table">
            <thead>
            <tr>
                <th>Text</th>
                <th>Helpful</th>
                <th>Non-Helpful</th>
                <th>Net-Helpful</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->text }}</td>
                    <td>{{ $review->helpful }}</td>
                    <td>{{ $review->non_helpful }}</td>
                    <td>{{ $review->helpful - $review->non_helpful }}</td>
                </tr>
            @endforeach
            {{ $reviews->links() }}
            </tbody>
        </table>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')