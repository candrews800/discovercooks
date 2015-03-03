$('.subscriber_count').click(function(){
    var clicked = this;
    var slug = $(clicked).data('slug');
    if($(clicked).hasClass('saved')){
        var url = "http://discovercooks.com/cookbook/removeRecipe/" + slug;
        $.ajax({
            url: url
        }).done(function(){
            var num = parseInt($(clicked).find('.num').text()) - 1;
            $(clicked).find('.num').text(num);
            $(clicked).removeClass('saved');
            $(clicked).find('save-button').text('Save');
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
        });
    }
});