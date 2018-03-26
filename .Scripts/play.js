function play(id, title){
    $('#vid'+id).addClass('video-container-active');
    document.getElementById('vid'+id).innerHTML = "<div id='vid"+id+"' class='vid-close'>X</div>"+
        "<video id='_vid"+id+"' controls preload='auto' width='100%' height='99%' data-setup='{}'><source src='./"+title+"'></video>";
}
