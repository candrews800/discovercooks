$(function() {
    $( "#directions-list" ).sortable({
        items: "li:not(.helper)",
        handle: '.directions-move',
        cursor: 'move'
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
$(function () {
    $('#recipe-quantity').tooltip({
        trigger: 'manual'
    });

    $('#recipe-quantity').on("change keyup paste blur",function(){
        var quantity = $(this).val();
        if(!isValidQuantity(quantity)){
            $(this).tooltip('show');
        }
        else{
            $(this).tooltip('hide');
        }
    });

    $('#recipe-quantity, #recipe-quantity-type, #recipe-ingredient').on("change keyup paste blur",function(){
        updateIngredientHelper();
    });

    registerNewListItem();
    appendIngredientHelper();
});

function isValidQuantity(num){
    if(! isNaN(num)){
        return true;
    }
    // Should only accept 1/2 or 1 1/2 format
    var fraction = /^(\d+\s)?\d+\/\d+$/;
    if(fraction.test(num)){
        return true;
    }

    return false;
}

$(function() {
    $( "#ingredient-list" ).sortable({
        handle: '.ingredients-move',
        cursor: 'move'
    });
    $( "#ingredient-list" ).on( "sortupdate", function( event, ui ) {
        deleteIngredientHelper();
        setIngredientInput()
        appendIngredientHelper();
    } );

    registerNewListItem();
});

$("#add-ingredient").click(function(e){
    e.preventDefault();
    deleteIngredientHelper();
    addIngredient();
    appendIngredientHelper();
    $("#recipe-quantity").focus();
});


// When User hits enter on ingredient text form, prevent form submit and add ingredient
$('#recipe-ingredient, #recipe-quantity').bind('keypress keydown keyup', function(e){
    if(e.keyCode == 13) {
        e.preventDefault();
        deleteIngredientHelper();
        addIngredient();
        appendIngredientHelper();
        $("#recipe-quantity").focus();
    }
});

function addIngredient(){
    var recipeQuantity = $("#recipe-quantity").val();
    var recipeQuantityType = $("#recipe-quantity-type").val();
    var recipeIngredient = $("#recipe-ingredient").val();

    if(recipeQuantity != "" && recipeIngredient != "" && isValidQuantity(recipeQuantity)){
        var ingredient = recipeQuantity + ' ' + recipeQuantityType + ' ' + recipeIngredient;

        $('#ingredient-list').append(
            '<li><span>' + ingredient + '</span> <a class="ingredient-delete" href="#"><i class="glyphicon glyphicon-remove"></i></a> <a class="ingredient-edit" href="#"><i class="glyphicon glyphicon-pencil"></i></a>');

        registerNewListItem();
        setIngredientInput();

        $("#recipe-quantity").val('');
        $("#recipe-ingredient").val('');
    }
}

function registerNewListItem(){
    $(".ingredient-delete").click(function(e){
        e.preventDefault();
        var listItem = $(this).parent();
        deleteIngredientHelper();
        deleteIngredient(listItem);
        appendIngredientHelper();
        $("#recipe-quantity").focus();
    });

    $(".ingredient-edit").click(function(e){
        e.preventDefault();
        var listItem = $(this).parent();
        deleteIngredientHelper();
        editIngredient(listItem);
        appendIngredientHelper();
        $("#recipe-quantity").focus();
    });
}

function deleteIngredient(listItem){
    $(listItem).remove();
    setIngredientInput();
}

function editIngredient(listItem){
    var ingredient = listItem.find('span').text();

    var quantityTypeOptions = [];

    $("#recipe-quantity-type option").each(function(index) {
        quantityTypeOptions[index] = $(this).val();
    });

    var startPosType, typeLength;
    var earliestMatch = 100;
    var earliestMatchIndex;
    for(var i = 0; i < quantityTypeOptions.length; i++){
        if(ingredient.indexOf(quantityTypeOptions[i]) > -1 && ingredient.indexOf(quantityTypeOptions[i]) < earliestMatch){
            earliestMatch =  ingredient.indexOf(quantityTypeOptions[i]);
            earliestMatchIndex = i;
        }
    }
    startPosType = earliestMatch;
    typeLength = quantityTypeOptions[earliestMatchIndex].length;

    var recipeQuantity = ingredient.slice(0, startPosType-1);
    var recipeQuantityType = ingredient.substr(startPosType, typeLength);
    var recipeIngredient = ingredient.slice(startPosType + typeLength+1);


    $(listItem).remove();
    setIngredientInput();


    $("#recipe-quantity").val(recipeQuantity);
    $("#recipe-quantity-type").val(recipeQuantityType);
    $("#recipe-ingredient").val(recipeIngredient);
}

function setIngredientInput(){
    var ingredients = "";

    $('#ingredient-list span').each(function(){
        if(ingredients == ""){
            ingredients = $(this).text();
        }
        else{
            ingredients += "<>" + $(this).text();
        }
    });

    console.log(ingredients);
    $('#ingredients').val(ingredients);
}

function appendIngredientHelper(){
    $('#ingredient-list').append(
        '<li class="helper"><span></span>');

    updateIngredientHelper();
}

function deleteIngredientHelper(){
    $('#ingredient-list .helper').remove();
}

function updateIngredientHelper(){

    var recipeQuantity = $("#recipe-quantity").val();
    var recipeQuantityType = $("#recipe-quantity-type").val();
    var recipeIngredient = $("#recipe-ingredient").val();

    var ingredient = recipeQuantity + ' ' + recipeQuantityType + ' ' + recipeIngredient;

    if(recipeQuantity == '' && recipeIngredient == ''){
        $('#ingredient-list .helper span').text('');
        $('#ingredient-list .helper').hide();
    }
    else{
        $('#ingredient-list .helper').show();
        $('#ingredient-list .helper span').text(ingredient);
    }
}
$('.dropzone').html5imageupload({

});
$(".review-text").readmore({
    embedCSS: false,
    collapsedHeight: 40,
    moreLink: '<a class="more" href="#">Read more</a>',
    lessLink: '<a class="more" href="#">Close</a>'
});
$('.subscriber_count').click(function(){
    var clicked = this;
    var slug = $(clicked).data('slug');
    var button = $(clicked).find('button');
    if($(clicked).hasClass('saved')){
        var url = "http://discovercooks.com/cookbook/removeRecipe/" + slug;
        $.ajax({
            url: url
        }).done(function(){
            var num = parseInt($(clicked).find('.num').text()) - 1;
            $(clicked).find('.num').text(num);
            $(clicked).removeClass('saved');
            $(clicked).find('save-button').text('Save');
            button.addClass('btn-success').removeClass('btn-danger');
            button.text('Save Recipe');
        });
    }
    else{
        var url = "http://discovercooks.com/cookbook/addRecipe/" + slug;
        $.ajax({
            url: url
        }).done(function(){
            var num = parseInt($(clicked).find('.num').text()) + 1;
            $(clicked).find('.num').text(num);
            $(clicked).addClass('saved');
            $(clicked).find('save-button').text('Saved');
            button.addClass('btn-danger').removeClass('btn-success');
            button.text('Saved');
        });
    }
});
$(function() {
    $('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top - 120
                }, 500);
                return false;
            }
        }
    });
});
function textCounter(field,field2,maxlimit) {
    var countfield = document.getElementById(field2);
    console.log(countfield.value);
    if (field.value.length > maxlimit) {
        field.value = field.value.substring(0, maxlimit);
        return false;
    } else {
        countfield.innerHTML = maxlimit - field.value.length;
    }
}