@extends('forum.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getBreadcrumbs(array(array('text' => 'Forums Home', 'url' => url('forum'))), $topic->name) }}
@overwrite

@section('header')
    {{ $topic->name }}
@stop

@section('content')
    <div class="col-xs-2">
        <a class="flat-button flat-button-green flat-button-small" href="{{ url(Request::url().'/create') }}">Create Post</a>
    </div>
    <div class="col-xs-10">
        <div id="forum-pagination" class="clearfix">
            {{ $posts->links() }}
        </div>
    </div>
    <div class="col-xs-12">
        <table id="post-listing">
            <colgroup>
                <col span="1" style="width: 4%;">
                <col span="1" style="width: 41%;">
                <col span="1" style="width: 18%;">
                <col span="1" style="width: 6%;">
                <col span="1" style="width: 6%;">
                <col span="1" style="width: 15%;">
                <col span="1" style="width: 5%;">
            </colgroup>
            <thead>
                <tr>
                    <th class="header-status"></th>
                    <th class="header-name">Subject</th>
                    <th class="header-author">Author</th>
                    <th class="header-replies">Replies</th>
                    <th class="header-views">Views</th>
                    <th class="header-activity-date" colspan="2">Last Post</th>
                </tr>
            </thead>
            <tbody>
            <!-- Display Posts-->
            @if(!$posts->isEmpty())
                @foreach($posts as $post)
                    <tr class="post">
                        <td class="post-status"><i class="glyphicon glyphicon-folder-open"></i></td>
                        <td class="post-name"><a href="{{ url('forum/'.str_replace(' ', '-', $topic->name).'/'.$post->id) }}">{{ $post->title }}</a></td>
                        <td class="post-author"><a href="{{ url('profile/'.$post->author->username) }}">{{ $post->author->username }}</a></td>
                        <td class="post-replies">{{ $post->reply_count }}</td>
                        <td class="post-views">{{ $post->view_count }}</td>
                        @if($post->activity)
                            <td class="post-activity-author">{{ $post->activity->author->username }}</td>
                            <td class="post-activity-date">{{ $post->lastActivity() }}</td>
                        @else
                            <td class="post-activity-author">{{ $post->author->username }}</td>
                            <td class="post-activity-date">{{ $post->lastActivity() }}</td>
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="col-xs-2">
        <a class="flat-button flat-button-green flat-button-small" href="{{ url(Request::url().'/create') }}">Create Post</a>
    </div>
    <div class="col-xs-10">
        <div id="forum-pagination" class="clearfix">
            {{ $posts->links() }}
        </div>
    </div>

@stop