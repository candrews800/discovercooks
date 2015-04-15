@include ('admin.layout.header')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Manage Blog Posts</h1>

        @foreach($posts as $post)
            <p>
                <a href="{{ url('admin/blog/post/'.$post->id) }}">{{ $post->title }}</a>
            </p>
        @endforeach
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->


@include('admin.layout.footer')