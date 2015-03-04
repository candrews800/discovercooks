@extends('forum.templates.default')

@section('content')
    <div class="col-xs-12">
        @foreach($categorys as $category)
            <div class="category">
                <h2>{{ $category->name }}</h2>
                <div class="row">
                    <?php $count = 0; ?>
                    @foreach($topics as $key => $topic)
                        @if($topic->category_id == $category->id)
                        @if($count % 3 == 0)
                            <div class="clearfix">
                        @endif
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="topic">
                                    <h3><a href="{{ url('forum/'.str_replace(' ', '-', $topic->name)) }}">{{ $topic->name }}</a></h3>
                                    <p>{{ $topic->description }}</p>
                                </div>
                            </div>
                            <?php $count++ ?>
                        @if($count % 3 == 0 && $count > 0 || $key == sizeof($topics)-1)
                            </div>
                        @endif
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@stop