$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $('.select_list_menu li').click(function(){
        $('.select_list_menu li.active').removeClass('active');
        $(this).toggleClass('active');
        $('.hide').removeClass("show");
        $('#' + $( this).data('item_to_show')).addClass("show");
        console.log("test");
    })
});
