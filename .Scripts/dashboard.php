<?php
function get_dls(){
    $output = "";
    $objects = scandir(".Partial");
    foreach ($objects as $object) {
        if($object != '.' && $object != '..' && is_file(".Partial/$object")){
            $output = $output."<div id=$object class='partial-listing'>
                                <div class='close' onclick='cancel(this.parentNode.id)'>X</div>
                                <div class='loading'></div>
                                ".substr($object, 0, -5)."</div>"; 
        }
    }
    if ($output == ""){
        $output = "<p style='text-align:center;margin-top:50px;'>There are no active downloads.</p>";
    }
    echo $output;
}

function cancel($torrent){
    //$pid = fgets(fopen("../.Partial/$torrent", 'r'));
    $pid = exec("cat ../.Partial/$torrent");
    $pid = $pid + 1;
    error_log($pid);
    exec("kill $pid");
    sleep(3);
}

if (isset($_POST['torrent_php'])){
    cancel($_POST['torrent_php']);
}
?>
