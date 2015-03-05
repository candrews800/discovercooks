@extends('forum.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getBreadcrumbs(array(
    array('text' => 'Forums Home', 'url' => url('forum')),
    array('text' => $topic->name, 'url' => url('forum/'.str_replace(' ', '-', $topic->name)))
    ), $post->title) }}
@overwrite

@section('header')
    {{ $post->title }}
@stop

@section('content')
    <div id="reply-header" class="clearfix">
        <div class="col-xs-2">
            <a class="flat-button flat-button-green flat-button-small" href="#add-reply">Add Reply</a>
        </div>
        <div class="col-xs-10">
            <div id="forum-pagination" class="clearfix">
                {{ $replys->links() }}
            </div>
        </div>
    </div>
    @if(!Input::get('page') || Input::get('page') < 2)
    <div class="col-xs-12 reply">
        <div class="row">
            <div class="post-sidebar col-xs-3">
                <div class="row">
                    <div class="col-xs-4">
                        <img class="forum-avatar" src="{{ url(ViewHelper::getUserImage($post->author->image)) }}" />
                    </div>
                    <div class="col-xs-8">
                        <a href="{{ url('profile/'.$post->author->username) }}" class="author">{{ $post->author->username }}</a>
                        <p class="post-count">Posts: {{ $post->author->post_count }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xs-7">
                <p class="reply-content">{{ nl2br(ForumHelper::convertToHtml(e($post->text))) }}</p>
                @if($post->created_at != $post->updated_at)
                    <p class="last-edited">
                        Last edited {{ $post->updated_at->diffForHumans() }}
                    </p>
                @endif
            </div>
            <div class="col-xs-2">
                <a id="1" class="reply-number" href="#1">#1</a>
                <p class="date">{{ $post->shortDate() }}</p>
            </div>
        </div>
        @if(Auth::id())
        <div class="action-bar">
            @if(Auth::user()->hasRole('Admin'))
                <a href="{{ Request::url() }}/delete" onclick="return confirm('Are you sure?')" class="small-button red">Delete</a>
            @endif
            @if($post->author_id == Auth::id() || Auth::user()->hasRole('Admin'))
            <a href="{{ Request::url() }}/edit" class="small-button orange">Edit</a>
            @endif
            @if(Auth::user()->hasRole('Admin'))
                @if($post->sticky)
                    <a href="{{ Request::url() }}/removeSticky" class="small-button">Remove Sticky</a>
                @else
                    <a href="{{ Request::url() }}/addSticky" class="small-button">Make Sticky</a>
                @endif
            @endif
            <a href="#add-reply" class="small-button">Reply</a>
            <a href="#add-reply" class="add-quote small-button"><i class="glyphicon glyphicon-comment"></i></a>
        </div>
        @endif
    </div>
    @endif
    @if(!$replys->isEmpty())
        @foreach($replys as $reply)
            <div class="col-xs-12 reply">
                <div class="row">
                    <div class="post-sidebar col-xs-3">
                        <div class="row">
                            <div class="col-xs-4">
                                <img class="forum-avatar" src="{{ url(ViewHelper::getUserImage($reply->author->image)) }}" />
                            </div>
                            <div class="col-xs-8">
                                <a href="{{ url('profile/'.$reply->author->username) }}" class="author">{{ $reply->author->username }}</a>
                                <p class="post-count">Posts: {{ $reply->author->post_count }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-7">
                        <p class="reply-content">{{ nl2br(ForumHelper::convertToHtml(e($reply->text))) }}</p>
                        @if($reply->created_at != $reply->updated_at)
                            <p class="last-edited">
                                Last edited {{ $reply->updated_at->diffForHumans() }}
                            </p>
                        @endif
                    </div>
                    <span class="anchor" id="{{ $reply->num }}"></span>
                    <div class="col-xs-2">
                        <a class="reply-number" href="#{{ $reply->num }}">#{{ $reply->num }}</a>
                        <p class="date">{{ $reply->shortDate() }}</p>
                    </div>
                </div>
                @if(Auth::id())
                <div class="action-bar">
                    @if(Auth::user()->hasRole('Admin'))
                        <a href="{{ url('forum/reply/'.$reply->id.'/delete') }}" onclick="return confirm('Are you sure?')" class="small-button red">Delete</a>
                    @endif
                    @if($reply->author_id == Auth::id() || Auth::user()->hasRole('Admin'))
                    <a href="{{ url('forum/reply/'.$reply->id) }}" class="small-button orange">Edit</a>
                    @endif
                    <a href="#add-reply" class="small-button">Reply</a>
                    <a href="#add-reply" class="add-quote small-button"><i class="glyphicon glyphicon-comment"></i></a>
                </div>
                @endif
            </div>
        @endforeach
    @endif

    <div class="col-xs-8">
        {{ ViewHelper::getBreadcrumbs(array(
    array('text' => 'Forums Home', 'url' => url('forum')),
    array('text' => $topic->name, 'url' => url('forum/'.str_replace(' ', '-', $topic->name)))
    ), $post->title) }}
    </div>
    <div class="col-xs-4">
        <div id="forum-pagination" class="clearfix">
            {{ $replys->links() }}
        </div>
    </div>

    <div id="add-reply" class="col-xs-12">
        @if(Auth::guest())
            <div class="row">
                <div class="col-xs-12 col-md-4 col-md-offset-4">
                    <a href="#" data-toggle="modal" data-target="#guest-login-modal" class="flat-button flat-button-small flat-button-green">Add Reply</a>
                </div>
            </div>
        @else
            <div class="row">
                <div class="post-sidebar col-xs-3">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>REPLY TO THREAD</h3>
                        </div>
                        <div class="col-xs-4">
                            <img class="forum-avatar" src="{{ url(ViewHelper::getUserImage($post->author->image)) }}" />
                        </div>
                        <div class="col-xs-8">
                            <a class="author">{{ $post->author->username }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-xs-7">
                    <div class="reply-actionbar">
                        <div class="row">
                            <div class="col-xs-9">
                                <a id="reply-bold" unselectable="on" href="#" class="small-button small-button-green">B</a>
                                <a id="reply-italic" href="#" class="small-button small-button-green">I</a>
                                <a id="reply-underline" href="#" class="small-button small-button-green">U</a>
                            </div>
                            <div class="col-xs-3">
                                <a id="edit-preview" href="#" class="flat-button flat-button-small flat-button-green">Preview</a>
                            </div>
                        </div>
                    </div>
                    {{ Form::open(array('url' => Request::url().'/addReply', 'id' => 'reply-form')) }}

                    {{ Form::textarea('text', null, array('id' => 'reply-textarea')) }}
                    <p id="preview-reply" class="reply-content"></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            {{ Form::submit('Submit', array('class' => 'flat-button flat-button-small flat-button-green')) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    </div>
@stop

@section('javascript')
<script>
    $('#edit-preview').click(function(event ){
        event.preventDefault();
        var replyContent = $('#reply-textarea').val();

        if($('#reply-textarea').is(":visible")){
            $('#reply-textarea').hide();
            $('#preview-reply').text(replyContent).show();
            convertToPreview();
            $('#edit-preview').text('Edit');
        }
        else{
            $('#reply-textarea').show();
            $('#preview-reply').hide();
            $('#edit-preview').text('Preview');
        }
    });

    function convertToPreview(){
        var replyContent = $('#preview-reply').text();
        replyContent = escapeHtml(replyContent);
        replyContent = replyContent.replace(/\[b\]/g,'<b>');
        replyContent = replyContent.replace(/\[\/b\]/g,'</b>');
        replyContent = replyContent.replace(/\[i\]/g,'<em>');
        replyContent = replyContent.replace(/\[\/i\]/g,'</em>');
        replyContent = replyContent.replace(/\[u\]/g,'<u>');
        replyContent = replyContent.replace(/\[\/u\]/g,'</u>');
        replyContent = replyContent.replace(/\n/g,'<br />');
        $('#preview-reply').html(replyContent);

    }

    var entityMap = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': '&quot;',
        "'": '&#39;',
        "/": '/'
    };

    function escapeHtml(string) {
        return String(string).replace(/[&<>"'\/]/g, function (s) {
            return entityMap[s];
        });
    }

    $('#reply-bold').click(function(event){
        event.preventDefault();
        insertElement('b');
    });

    $('#reply-italic').click(function(event){
        event.preventDefault();
        insertElement('i');
    });

    $('#reply-underline').click(function(event){
        event.preventDefault();
        insertElement('u');
    });

    function insertElement(element){
        var replyContent = $('#reply-textarea').val();

        var selection = GetSelection();
        console.log(selection);
        if(selection['start'] != selection['end']){
            replyContent = replyContent.slice(0,selection['start']) + "[" + element + "]" + selection['text'] + '[/' + element + ']' + replyContent.slice(selection['end']);
        }
        else{
            replyContent += "[" + element + "][/" + element + ']';
        }
        $('#reply-textarea').val(replyContent);
    }

    function GetSelection()
    {
        var textComponent = document.getElementById('reply-textarea');
        var selectedText;
        // IE version
        if (document.selection != undefined)
        {
            textComponent.focus();
            var sel = document.selection.createRange();
            selectedText = sel.text;
        }
        // Mozilla version
        else if (textComponent.selectionStart != undefined)
        {
            var startPos = textComponent.selectionStart;
            var endPos = textComponent.selectionEnd;
            selectedText = textComponent.value.substring(startPos, endPos)

            var selection = [];
            selection['start'] = startPos;
            selection['end'] = endPos;
            selection['text'] = selectedText;

        }
        return selection;
    }
</script>
@stop