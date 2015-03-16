@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Payment Queue</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Paypal Email</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($queue as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->user->username }}</td>
                        <td>{{ $item->paypal_email }}</td>
                        <td>{{ $item->amount }}</td>
                        <td><a class="btn btn-primary" href="{{ url(Request::url().'/'.$item->id) }}">Sent</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- /.row -->


@include('admin.layout.footer')