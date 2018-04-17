function play(id, title, type){
    $('#vid'+id).addClass('video-container-active');
    $(".menu-container").addClass('nb-active-dl');
    $(".item-container").css('pointer-events','none');
    $('body').css('overflow-y', 'hidden');

    if (type == 'name'){
        document.getElementById('vid'+id).innerHTML = "<div id='vid"+id+"' class='vid-close'>X</div>"+
            "<video src=\"./"+title+"\" id='_vid"+id+"' class='video-js vjs-default-skin' autoplay controls='true' preload='auto' width='100%' height='99%' data-setup='{}'><source src=\"./"+title+"\" type='video/mp4'><source src=\"./"+title+"\" type='video/webm'></video>";
    } else {
        document.getElementById('vid'+id).innerHTML = "<div id='vid"+id+"' class='vid-close'>X</div>"+
            "<video src=\""+title+"\" id='_vid"+id+"' class='video-js vjs-default-skin' autoplay controls='true' preload='auto' width='100%' height='99%' data-setup='{}'><source src=\"./"+title+"\" type='video/mp4'><source src=\"./"+title+"\" type='video/webm'></video>";
    }
    if (screen.width >= 760){
        videojs('_vid'+id, {}, function(){
        });
    }
    $(document).keyup(function(event) {
        if(event.keyCode == 27){
            if (screen.width >= 760){
                videojs("_vid"+id).dispose();
            }
            $('.video-container').removeClass('video-container-active');
            $('.video-container').html("");
            $(".menu-container").removeClass('nb-active-dl');
            $(".item-container").css('pointer-events','');
            $('body').css('overflow-y', 'auto');
        }
    });
    $('.vid-close').on('click', function(e){
        if (screen.width >= 760){
            videojs("_vid"+id).dispose();
        }
        $(this).parent().removeClass('video-container-active');
        $(this).parent().html("");
        $(".menu-container").removeClass('nb-active-dl');
        $(".item-container").css('pointer-events','');
        $('body').css('overflow-y', 'auto');
    });
}

function get_results(method){
    //Checks active download provider and then grabs results from tor.php
    if (method == 'stream'){
        document.getElementById('sresult_container').innerHTML = "<div class='loading'></div>";
        var input = document.getElementById('sn').value;
        var site = $('.s-choice-active').attr('id');
    } else {
        document.getElementById('result_container').innerHTML = "<div class='loading'></div>";
        var input = document.getElementById('dn').value;
        var site = $('.t-choice-active').attr('id');
    }
    $.ajax({
        url : '/.Scripts/tor.php',
        data: {site_q: site, search_q: input},
        type:"POST",
        context: document.body
    }).done(function(data) {
        if (method == 'stream'){
            document.getElementById('sresult_container').innerHTML = data;
        } else {
            document.getElementById('result_container').innerHTML = data;
        }
    });
}

function grab_dl(title, method){
    //Initiates download of chosen file
    if (method == 'dl'){
        var tor_site = $('.t-choice-active').attr('id');
    } else {
        var tor_site = $('.s-choice-active').attr('id');
    }
    $.ajax({
        url : '/.Scripts/tor.php',
        data: {tor_site_q: tor_site, grab_q: title, grab_l: window.location.pathname},
        type:"POST",
        context: document.body
    }).done(function(data) {
        $('body').removeClass('dnf-body');
        if (data == "success"){
            $('.dnf_container').removeClass('dnf-active');
            $(document.body).prepend("<div class='notify'>Your download will start soon!</div>");
        } else if (data == "error") {
            $('.dnf_container').removeClass('dnf-active');
            $(document.body).prepend("<div class='notify'>An error has occurred. Please try again.</div>");
        } else {
            var client = new WebTorrent();
            console.log(data);
            var torrentId = data;

            client.add(torrentId, function (torrent) {
                var file = torrent.files.find(function (file) {
                    return file.name.endsWith('.mp4');
                })

                file.appendTo('body');
            })
        }
    });
}

