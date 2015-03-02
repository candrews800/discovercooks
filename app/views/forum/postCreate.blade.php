@extends('forum.templates.default')

@section('breadcrumbs')
    {{ ViewHelper::getBreadcrumbs(array(
    array('text' => 'Forums Home', 'url' => url('forum')),
    array('text' => $topic->name, 'url' => url('forum/'.str_replace(' ', '-', $topic->name))),
    ), 'Create Post') }}
@overwrite

@section('content')
    <div id="add-reply" class="col-xs-12">
        <div class="row">
            <div class="post-sidebar col-xs-3">
                <div class="row">
                    <div class="col-xs-12">
                        <h3>CREATE POST</h3>
                    </div>
                    <div class="col-xs-4">
                        <img class="forum-avatar" src="{{ url(ViewHelper::getUserImage(Auth::user()->image)) }}" />
                    </div>
                    <div class="col-xs-8">
                        <a class="author">{{ Auth::user()->username }}</a>
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

                {{ Form::open(array('url' => Request::url(), 'id' => 'reply-form')) }}
                {{ Form::text('title') }}
                {{ Form::textarea('text', null, array('id' => 'reply-textarea')) }}
                <p id="preview-reply" class="reply-content"></p>
                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        {{ Form::submit('Create Post', array('class' => 'flat-button flat-button-small flat-button-green')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
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