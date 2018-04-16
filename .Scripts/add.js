$(document).ready(function(){

    if (screen.width >= 760){
        $('head').append('<script src="http://vjs.zencdn.net/6.6.3/video.js"></script>');
    }

//Click detection for the UI
    var bs = 0;
    var dlss = 0;
    var base = -220;
    var children = $('.breadcrumbs').children().length;
    for (var child = 0; child < $('.breadcrumbs').children().length - 2; child++){
        base = base - 70;
    }
    if ($(window).width() < 760){
        $('.breadcrumbs').css("margin-top", base);
     }
    $(window).resize(function() {
        if ($(window).width() < 760){
            $('.breadcrumbs').css("margin-top", base);
        }else {
            $('.breadcrumbs').css("margin-top", "50px");
    }});
    $('body').keyup(function(event) {
        var key = String.fromCharCode(event.keyCode).toLowerCase();
        document.getElementById(key).scrollIntoView();
    });
    $('.letter-head').on('click',function(){
        var letter = 65;
        var str ="<div class='letter-chooser'>";
        while (letter < 91){
            str +="<span class='letter'>"+String.fromCharCode(letter).toUpperCase()+"</span>";
            letter++;
        }
        var self = this;
        $(this).fadeOut(400);
        setTimeout(function(){
            $(self).html(str);
            $('.letter').on('click',function(){
                $(this).parent().parent().addClass('letter-chooser-active');
                var key = $(this).html().toLowerCase();
                document.getElementById(key).scrollIntoView();
            });
        }, 400);
        $(this).fadeIn(400);
        setTimeout(function(){
            if ($(self).hasClass('letter-chooser-active')){
                $(self).html($(self).attr('id').toUpperCase());
                $(self).removeClass('letter-chooser-active');
            }
        }, 400);
    });
    $('.search-button').on('click',function(e){
        if ($('.search-form').hasClass('search-form-active')){
            $(this).removeClass('search-button-m-active');
            $('.search-form').removeClass('search-form-active');
        } else {
            $('.search-form').addClass('search-form-active');
            $(this).addClass('search-button-m-active');
        }
    });
    $("#dn").keyup(function(event) {
        if(event.keyCode == 13){
            $("#dnb").click();
        }
    });
    $("#rena").keyup(function(event) {
        if(event.keyCode == 13){
            $("#renas").click();
        }
    });
    $('.letter-head-tog').on('click',function(){
        if ($('.letter-head').hasClass('letter-head-active')){
            $('.letter-head').removeClass('letter-head-active');
        } else {
            $('.letter-head').addClass('letter-head-active');}
    });
    $('.item-ren').on('click', function(){
        $('.ren_container').addClass('ren-active');
        $(this).siblings('.file-item').attr('id','rename');
    });
    $('#renc').on('click', function(){
        $('.ren_container').removeClass('ren-active');
        $('#rename').removeAttr('id');
    });
    $('#renas').on('click', function(){
        rename($('#rename').html(), $('#rena').val());
    });
    $('.mobile-bc-tog').on('click', function(e){
        $(this).addClass('mbt-active');
        $('.breadcrumbs').addClass('mbc-active');
    });
    $('.vid-close-active').on('click', function(e){
        $(this).parent().removeClass('video-container-active');
        $(this).parent().html("");
    });
    $('.new-button').on('click', function(){
        if (bs == 0) {
                $('.new-menu').addClass('nm-active');
                $('.dl-button').addClass('nb-active-dl');
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
        $('body').addClass('dnf-body');
    });
    $(".box-del").on('click', function(){
        $(".dd_container").addClass('dd-active');
        $("#dd_submit").html("<a href='"+$(this).attr('id')+"'><button>Yes</button></a>");
    });
    $("#ddc").on('click', function(){
        $(".dd_container").removeClass('dd-active');
    });
    $('#cndc').on('click', function(e) {
        $('.cnd_container').removeClass('cnd-active');
    });
    $('#umc').on('click', function(e) {
        $('.um_container').removeClass('um-active');
    });
    $('#dnfc').on('click', function(e) {
        $('body').removeClass('dnf-body');
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
    $('.search-button').on('click', function(e) {
        e.stopPropagation();
    });
    $('.search-form').on('click', function(e) {
        e.stopPropagation();
    });
    $('.menu-container').on('click', function(e) {
        e.stopPropagation();
    });
    $('.mobile-bc-tog').on('click', function(e) {
        e.stopPropagation();
    });
    $('.breadcrumbs').on('click', function(e) {
        e.stopPropagation();
    });
    $(document).on('click', function(e){
        $('.search-form').removeClass('search-form-active');
        $('.search-button').removeClass('search-button-m-active');
        $('.dl-button').removeClass('nb-active-dl');
        $('.new-menu').removeClass('nm-active');
        $('.new-button').removeClass('nb-active');
        $('.mobile-bc-tog').removeClass('mbt-active');
        $('.breadcrumbs').removeClass('mbc-active');
        bs = 0;
    });
});
function rename(file, name) {
    file_prefix = window.location.pathname;
    $.ajax({
        url: '/functions.php',
        data: {file_prefix_q: file_prefix, file_q: file, name_q: name},
        type:"POST",
        context: document.body
    }).done(function() {
        location.reload();
    });
}
$(function() {
    $(".box-container").draggable({
        start: function(event, ui){
            $('.box-del').css("opacity","0");
        },
        stop: function(event, ui){
            $('.box-del').css("opacity","");
        },
        revert:"invalid",
        cursor:"move",cursorAt:{top:100,left:100}
    });
    $(".breadcrumb,.box-container").droppable({
        over: function(event, ui) {
            $('.ui-draggable-dragging .dir-box').addClass('hover-active');
        },
        out: function(event, ui) {
            $('.ui-draggable-dragging .dir-box').removeClass('hover-active');
        },
        drop: function(event, ui){
            var path = window.location.pathname;
            if ($(this).hasClass("breadcrumb")){
                var loc = "/"+$(this).parent().attr("href").split("/")[1];
            } else {var loc = path+$(this).children("a").attr("href").split("/")[1];}

            var orig = path+$(ui.draggable[0]).children("a").attr("href").split("/")[1];
            console.log(loc,orig);

            $.ajax({
                url:'/functions.php',
                data: {dest: loc, source: orig},
                type:"POST",
                context:document.body
            }).done(function() {
                location.reload();
            });
        }
    });
});
