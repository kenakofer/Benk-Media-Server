$(document).ready(function(){
    var bs = 0;
    $('.new-button').on('click', function(){
        if (bs == 0) {
                $('.new-menu').addClass('nm-active');
                $(this).addClass('nb-active');
                bs = 1;
        } else {
                $('.new-menu').removeClass('nm-active');
                $(this).removeClass('nb-active');
                bs = 0;
        }
    });
    $('#cnd').on('click', function(e) {
        $('.new-menu').removeClass('nm-active');
        $('.new-button').removeClass('nb-active');
        $('.cnd_container').addClass('cnd-active');
    });
    $('#um').on('click', function(e) {
        $('.new-menu').removeClass('nm-active');
        $('.new-button').removeClass('nb-active');
        $('.um_container').addClass('um-active');
    });
    $('#cndc').on('click', function(e) {
        $('.cnd_container').removeClass('cnd-active');
    });
    $('#umc').on('click', function(e) {
        $('.um_container').removeClass('um-active');
    });
    $('.menu-container').on('click', function(e) {
        e.stopPropagation();
    });
    $(document).on('click', function(e){
        $('.new-menu').removeClass('nm-active');
        $('.new-button').removeClass('nb-active');
        bs = 0;
    });
});