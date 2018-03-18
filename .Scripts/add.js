$(document).ready(function(){
    $('.new-button').on('click', function(){
        console.log('ab');
        $('.new-menu').addClass('nm-active');
        $(this).addClass('nb-active');
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
    $('.menu-container').on('click', function(e) {
        e.stopPropagation();
    });
    $(document).on('click', function(e){
        $('.new-menu').removeClass('nm-active');
        $('.new-button').removeClass('nb-active');
    });
});
