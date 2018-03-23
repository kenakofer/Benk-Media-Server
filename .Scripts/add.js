$(document).ready(function(){
//Click detection for the UI
    var bs = 0;
    $("#dn").keyup(function(event) {
        if(event.keyCode == 13){
            $("#dnb").click();
        }
    });
    $('.video-container').on('click', function(){
        $(this).removeClass('video-container-active');
        $(this).html("");
    });
    $('.new-button').on('click', function(){
        if (bs == 0) {
                $('.dl-button').addClass('nb-active-dl');
                $('.new-menu').addClass('nm-active');
                $(this).addClass('nb-active');
                bs = 1;
        } else {
                $('.dl-button').removeClass('nb-active-dl');
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
    $('#dnf').on('click', function(e) {
        $('.new-menu').removeClass('nm-active');
        $('.new-button').removeClass('nb-active');
        $('.dnf_container').addClass('dnf-active');
    });
    $('#cndc').on('click', function(e) {
        $('.cnd_container').removeClass('cnd-active');
    });
    $('#umc').on('click', function(e) {
        $('.um_container').removeClass('um-active');
    });
    $('#dnfc').on('click', function(e) {
        $('.dnf_container').removeClass('dnf-active');
    });
    $('#tc1').on('click', function(){
        $(this).addClass('t-choice-active');
        $('#tc2').removeClass('t-choice-active');
    });
    $('#tc2').on('click', function(){
        $(this).addClass('t-choice-active');
        $('#tc1').removeClass('t-choice-active');
    });
    $('.menu-container').on('click', function(e) {
        e.stopPropagation();
    });
    $(document).on('click', function(e){
        $('.dl-button').removeClass('nb-active-dl');
        $('.new-menu').removeClass('nm-active');
        $('.new-button').removeClass('nb-active');
        bs = 0;
    });
});
