<?php
function get_dls(){
//Gets a list of all active downloads by checking for their directories in .Partial
    $output = "";
    $dls_in_progress = explode("\n", file_get_contents('../.Partial/downloads'));
    foreach($dls_in_progress as $line){
	if ($line == ""){
	    continue;
	}

	$line = explode("|", $line);
    $name = substr($line[0], strrpos($line[0], '/') + 1);
    $percent = $line[2];
    if ($percent == 'NAN'){
       $percent = "Initializing..."; 
    } else if ($percent == "0"){
       $percent = "Validating..."; 
    }
	$output = $output."<div id='$line[1]' class='partial-listing'>
				<div class='close' onclick=\"cancel('$line[1]','$name')\">X</div>
				<div class='loading'></div>
				$name
				<p style='float:right;margin-right:30px;margin-top:2px;'>".$percent."</div>";
    }
    if ($output == ""){
        $output = "<p style='text-align:center;margin-top:20vh;'>There are no active downloads.</p>";
    }
    echo $output;
}

function cancel($gid, $name){
    //Cancels a torrent by creating a file that is read by scan.php
    $file = fopen("../.Partial/$name.$gid", 'w');
    fclose($file);
}

if (isset($_POST['gid_post'])){
    //Allows the cancel function to be called from JS
    cancel($_POST['gid_post'], $_POST['name_post']);
} else {
    get_dls();
}
?>
