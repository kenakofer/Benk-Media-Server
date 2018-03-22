function get_results(){
//Checks active download provider and then grabs results from tor.php
    document.getElementById('result_container').innerHTML = "<div class='loading'></div>";
    var input = document.getElementById('dn').value;
    var site = $('.t-choice-active').attr('id');
    console.log(site);
    $.ajax({
        url : '/.Scripts/tor.php',
        data: {site_q: site, search_q: input},
        type:"POST",
        context: document.body
    }).done(function(data) {
        document.getElementById('result_container').innerHTML = data;
    });
}

function grab_dl(title){
//Initiates download of chosen file
    var tor_site = $('.t-choice-active').attr('id');
    $.ajax({
        url : '/.Scripts/tor.php',
        data: {tor_site_q: tor_site, grab_q: title, grab_l: window.location.pathname},
        type:"POST",
        context: document.body
    });
    $('.dnf_container').removeClass('dnf-active');
    $(document.body).prepend("<div class='notify'>Your download has started!</div>");
}
