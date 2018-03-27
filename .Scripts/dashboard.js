$(window).bind("load", function refresh_wait(){
refresh();
setInterval(refresh, 5000);
});
function cancel(gid, name){
//Cancels a downloading torrent
    $.ajax({
        url : '.Scripts/dashboard.php',
        data: {gid_post: gid, name_post: name},
        type: "POST",
        context: document.body
    });
}
function refresh(){
    $.ajax({
        url : '.Scripts/dashboard.php',
        data: {},
        type: "POST",
        context: document.body
    }).done(function (data) {
       document.getElementById('dl_container').innerHTML = data; 
    });
}
