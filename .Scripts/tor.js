function get_results(){
    document.getElementById('result_container').innerHTML = "<div class='loading'></div>";
    var input = document.getElementById('dn').value;
    $.ajax({
        url : '/.Scripts/tor.php',
        data: {search_q: input},
        type:"POST",
        context: document.body
    }).done(function(data) {
        document.getElementById('result_container').innerHTML = data;
    });
}

function grab_dl(title){
    console.log(window.location.pathname);
    $.ajax({
        url : '/.Scripts/tor.php',
        data: {grab_q: title, grab_l: window.location.pathname},
        type:"POST",
        context: document.body
    });
    $('.dnf_container').removeClass('dnf-active');
    $(document.body).prepend("<div class='notify'>Your download has started!</div>");
}
