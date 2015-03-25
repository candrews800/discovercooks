/*
    Navbar
*/
/*
    Navbar Dropdown
*/

$(document).click(function(event) {
    if(!$(event.target).closest('#navbar-dropdown').length && !$(event.target).closest('.navbar-dropdown').length) {
        if($('#navbar-dropdown').is(":visible")) {
            hideNavDropdown();
            $('.navbar-dropdown').removeClass('active');
        }
    }
});

$('.navbar-dropdown').click(function(){
    $('.navbar-dropdown').removeClass('active');
    $(this).addClass('active');
    var target = $(this).data('target');
    if(canSeeContents(target)){
        hideNavDropdown();
        $('.navbar-dropdown').removeClass('active');
    }
    else{
        showNavDropdown();
        showNavDropdownContents(target);
    }
});

function hideNavDropdown(){
    hideNavDropdownContents();
    $('#navbar-dropdown').hide();
}

function showNavDropdown(){
    $('#navbar-dropdown').show();
}

function hideNavDropdownContents(){
    $('.navbar-dropdown-contents').hide();
}

function showNavDropdownContents(target){
    hideNavDropdownContents();
    target += "Dropdown"
    $('#'+target).show();
}

function canSeeContents(target){
    target += "Dropdown"
    if($('#'+target).is(':visible')){
        return true;
    }
    return false;
}

/*
    Navbar Search
*/

$(document).click(function(event) {
    if(!$(event.target).closest('#navbar-search-form input[type=text]').length && !$(event.target).closest('#navbar-search').length) {
        if($('#navbar-search-form input').is(":visible")) {
            hideSearch();
        }
    }
});

$('#navbar-search').click(function(){
    showSearch();
});

function showSearch(){
    $('#navbar-search-form').show();
    input = $('#navbar-search-form input[type=text]');
    input.show();


    logo_right = $('#logo').offset().left + $('#logo').outerWidth();
    form_right = $('#navbar-search-form').offset().left + $('#navbar-search-form').outerWidth();

    input.width(form_right - logo_right - 105);
    input.focus();
}

function hideSearch(){
    $('#navbar-search-form').hide();
    input = $('#navbar-search-form input[type=text]');
    input.hide();
}

/*
 Enable Tooltip for Register Modal
 */
$('#register-form').change(function(){
    var filledForm = isFilledOut($(this));

    if(filledForm && !$('#terms-agree').is(':checked')){
        $('#terms-agree-popover').popover('show');
    }
});

$('#guest-register-modal').on('hidden.bs.modal', function(e){
    $('#terms-agree-popover').popover('hide');
});

function isFilledOut(form){
    var filledForm = true;
    if(!form.find('input[type=text]').val()){
        filledForm = false;
    }
    else if(!form.find('input[type=email]').val()){
        filledForm = false;
    }
    else{
        form.find('input[type=password]').each(function(){
            if(!$(this).val()){
                filledForm = false;
            }
        });
    }
    return filledForm;
}

/*
    Only enable register button once terms has been checked
 */

$('#terms-agree').change(function(){
    if($(this).is(':checked')){
        $('#register-submit-button').animate({
            disabled: false,
            opacity: 1.0
        }, 200);
    } else {
        $('#register-submit-button').animate({
            disabled: true,
            opacity: 0.4
        }, 200);
    }
});

/*
    Modal Switching
 */

$('#forgot_password_link').click(function(){
    $('#guest-login-modal').modal('hide');
});
$('#join_now_link').click(function(){
    $('#guest-login-modal').modal('hide');
    $('#guest-register-modal').modal('show');
});
$('#member_already_link').click(function(){
    $('#guest-register-modal').modal('hide');
    $('#guest-login-modal').modal('show');
});

/*
    Forum
 */
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

$('.add-quote').click(function(event){
    event.preventDefault();
    var text = $(this).parent().parent().parent().find('.reply-content').text();
    console.log($(this).parent().parent().parent().find('.reply-content'));

    $('#reply-textarea').append('[bq]' + text + '[/bq]');
});