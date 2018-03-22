function cancel(torrent){
//Cancels a downloading torrent
    $.ajax({
        url : '.Scripts/dashboard.php',
        data: {torrent_php: torrent},
        type: "POST",
        context: document.body
    }).done(function() {
        location.reload();   
    });
}
