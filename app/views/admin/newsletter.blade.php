@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Newsletter Signups</h1>

        @if($newsletter_emails->isEmpty())
            <p>No sign ups found.</p>
        @else
            @foreach($newsletter_emails as $email)
                {{ $email->email }},
            @endforeach
        @endif
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->



@include('admin.layout.footer')