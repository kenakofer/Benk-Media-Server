<?php
function copy_index($dir){
//Recursively copies index.php into all of the downloaded folders
    copy("../index.php", "$dir/index.php");
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if($object != '.' && $object != '..' && is_dir("$dir/$object")){
                copy_index("$dir/$object");
            }
        }
    reset($objects);
}

function remove_non_av($dir){
//Deletes all non audio/video files by checking MIME types
    if(is_dir($dir)){
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..' && $object != 'index.php'){
                if (is_file("$dir/".$object)){
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, "$dir/".$object);
                    if (!(strpos($mime, 'video') !== false) && !(strpos($mime, 'audio') !== false)) {
                        unlink($dir.'/'.$object);
                    }
                } else { remove_non_av($dir.'/'.$object); }
            }
            reset($objects);
        }
    }
}

exec('aria2c --enable-rpc --rpc-allow-origin-all -D');
$locations = [];
include 'Aria2.php';
$aria2 = new Aria2();

while(True){
error_log(print_r($locations));
$aria2->purgeDownloadResult();
//Runs continuously in background listening for download events
    $in_progress = "";

    foreach ($aria2->tellActive(["status","gid","dir","completedLength","totalLength"])['result'] as $result){
        $gid = $result['gid'];
        $dir = $result['dir'];

	if (file_exists("$dir.start")){
	    $file_contents = file_get_contents("$dir.start");
	    $file_contents = explode("\n", $file_contents);
            $location = $file_contents[1];
            if(!array_key_exists($location, $locations)){
                $locations[$gid] = $location;
            } 
            unlink("$dir.start");
        }

        if (file_exists("$dir.$gid")){
            $aria2->remove($gid);
            exec("rm -r $dir");
            unset($locations[$gid]);
            unlink("$dir.$gid");
            continue;
        }
	    
        $amount_done = $result['completedLength'];
        $total = $result['totalLength'];
	$percent = round($amount_done / $total, 2) * 100;

	if ($percent == 100){
	   $aria2->remove($gid); 
	   exec("chown -R www-data:www-data $dir");
	   copy_index($dir);
	   remove_non_av($dir);
           exec("mv $dir ..".$locations[$gid]);
           unset($locations[$gid]);
           continue;
	}
	$in_progress = $in_progress."$dir|$gid|$percent\n";
    }

    exec("echo '$in_progress' > ../.Partial/downloads");
    $objects = scandir("../.Partial");

    foreach ($objects as $object) {
        if($object != '.' && $object != '..' && is_dir("../.Partial/$object")){
	    if (file_exists("../.Partial/$object.start")){
		$file_contents = file_get_contents("../.Partial/$object.start");
		$file_contents = explode("\n", $file_contents);
		$aria2->addUri(
			[$file_contents[0]],
			['dir'=>"/var/www/bryceyoder.com/media_public_html/.Partial/$object",
			'seed-time'=>0]);
	    }

        }
    }
    sleep(5);
}

?>
