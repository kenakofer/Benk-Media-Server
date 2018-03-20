$(document).ready(function(){
    $.ajax({
        url : '/.Scripts/toasdfadsfr.php',
        data: {search_q: "Baby Driver"},
        type:"GET",
        context: document.body
    }).done(function(data) {
        console.log(data);
    });
});
