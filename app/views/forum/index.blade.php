@extends('forum.templates.default')

@section('content')
    <div class="col-xs-12">
        @foreach($categorys as $category)
            <div class="category">
                <h2>{{ $category->name }}</h2>
                <div class="row">
                    @foreach($topics as $key => $topic)
                        @if($key % 3 == 0)
                            <div class="clearfix">
                        @endif
                        @if($topic->category_id == $category->id)
                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="topic">
                                    <h3><a href="{{ url('forum/'.str_replace(' ', '-', $topic->name)) }}">{{ $topic->name }}</a></h3>
                                    <p>{{ $topic->description }}</p>
                                </div>
                            </div>
                        @endif
                        @if($key % 3 == 0)
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@stop