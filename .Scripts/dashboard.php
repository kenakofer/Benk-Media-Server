<?php
function get_dls(){
//Gets a list of all active downloads by checking for their directories in .Partial
    $output = "";
    $objects = scandir(".Partial");
    foreach ($objects as $object) {
        if($object != '.' && $object != '..' && is_dir(".Partial/$object")){
            $output = $output."<div id=$object class='partial-listing'>
                                <div class='close' onclick='cancel(this.parentNode.id)'>X</div>
                                <div class='loading'></div>
                                ".$object."</div>"; 
        }
    }
    if ($output == ""){
        $output = "<p style='text-align:center;margin-top:50px;'>There are no active downloads.</p>";
    }
    echo $output;
}

function cancel($torrent){
    //Cancels a torrent by creating a file that is read by scan.php
    $file = fopen("../.Partial/$torrent.cancel", 'w');
    fclose($file);
}

if (isset($_POST['torrent_php'])){
    //Allows the cancel function to be called from JS
    cancel($_POST['torrent_php']);
    sleep(10);
}
?>
