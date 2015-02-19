$(function() {
    $( "#directions-list" ).sortable({
        items: "li:not(.helper)"
    });
    $( "#directions-list" ).on( "sortupdate", function( event, ui ) {
        deleteDirectionHelper();
        setDirectionsInput();
        appendDirectionHelper();
    } );
    registerNewListItemDirections();
    appendDirectionHelper();
});

// When User hits enter on ingredient text form, prevent form submit and add ingredient
$('#recipe-directions').bind('keypress keydown keyup', function(e){
    if(e.keyCode == 13) {
        e.preventDefault();
        deleteDirectionHelper();
        addDirections();
        appendDirectionHelper();
        $("#recipe-directions").focus();
    }
});

$('#recipe-directions').on("change keyup paste blur",function(){
    updateDirectionHelper();
});

$("#add-directions").click(function(e){
    e.preventDefault();
    deleteDirectionHelper();
    addDirections();
    appendDirectionHelper();
    $("#recipe-directions").focus();
});

function addDirections(){
    var directions = $("#recipe-directions").val();
    directions = directions.trim();

    if(directions != ""){
        $('#directions-list').append(
            '<li><span>' + directions + '</span> <a class="directions-delete" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="directions-edit" href="#"><i class="glyphicon glyphicon-pencil"></i></a>');

        registerNewListItemDirections();
        setDirectionsInput();

        $("#recipe-directions").val('');
    }
}

function registerNewListItemDirections(){
    $(".directions-delete").click(function(e){
        e.preventDefault();
        var listItem = $(this).parent();
        deleteDirectionHelper();
        deleteDirections(listItem);
        appendDirectionHelper();
        $("#recipe-directions").focus();
    });

    $(".directions-edit").click(function(e){
        e.preventDefault();
        var listItem = $(this).parent();
        deleteDirectionHelper();
        editDirections(listItem);
        appendDirectionHelper();
        $("#recipe-directions").focus();
    });
}

function deleteDirections(listItem){
    $(listItem).remove();
    setDirectionsInput();
}

function editDirections(listItem){
    var directions = listItem.find('span').text();

    $(listItem).remove();
    setDirectionsInput();


    $("#recipe-directions").val(directions);
}

function setDirectionsInput(){
    var directions = "";

    $('#directions-list span').each(function(){
        if(directions == ""){
            directions = $(this).text();
        }
        else{
            directions += "<>" + $(this).text();
        }
    });

    $('#directions').val(directions);
}

function appendDirectionHelper(){
    $('#directions-list').append(
        '<li class="helper"><span></span>');

    updateDirectionHelper();
}

function deleteDirectionHelper(){
    $('#directions-list .helper').remove();
}

function updateDirectionHelper(){
    var directions = $('#recipe-directions').val();
    if(directions == ''){
        $('#directions-list .helper span').text('');
        $('#directions-list .helper').hide();
    }
    else{
        $('#directions-list .helper').show();
        $('#directions-list .helper span').text(directions);
    }
}