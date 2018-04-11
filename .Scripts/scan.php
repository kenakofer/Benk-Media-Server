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

function remove_non_av($dir, $destination){
    //Deletes all non audio/video files by checking MIME types
    //$destination = implode('/',array_slice(explode('/', $destination), 0, -1)); 
    if(is_dir($dir)){
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..' && $object != 'index.php'){
                if (is_file("$dir/".$object)){
                    $object_new = str_replace(" ","~",$object);
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, "$dir/".$object);
                    if (!(strpos($mime, 'video') !== false) && !(strpos($mime, 'audio') !== false)) {
                        unlink($dir.'/'.$object);
                    } else {
                       // $type_check_array = explode('.',$object);
                       // if (end($type_check_array) == 'mkv'){
                       //     $type_check_array = array_slice($type_check_array, 0, -1);
                       //     $object_new = implode('.',$type_check_array);
                       //     shell_exec("ffmpeg -i '".$dir.'/'.$object."' -c:v copy -c:a copy '".$dir.'/'.$object_new.".mp4' &");
                       //     unlink($dir.'/'.$object);
                       //     rename($dir.'/'.$object_new.'.mp4', '/var/www/media.bryceyoder.com'.$destination.'/'.$object_new.'.mp4');
                       // } else { rename($dir.'/'.$object, '/var/www/media.bryceyoder.com'.$destination.'/'.$object_new); }
                        rename($dir.'/'.$object, '/var/www/media.bryceyoder.com'.$destination.'/'.$object_new); 
                    }
                } else { remove_non_av($dir.'/'.$object, $destination); }
            }
            reset($objects);
        }
    }
}

exec('aria2c --enable-rpc --rpc-allow-origin-all -D -V');
$locations = [];
include 'Aria2.php';
$aria2 = new Aria2();

while(True){
    $aria2->purgeDownloadResult();
    //Runs continuously in background listening for download events
    $in_progress = "";
    foreach ($aria2->tellActive(["status","gid","dir","completedLength","totalLength"])['result'] as $result){

        $gid = $result['gid'];
        $dir = $result['dir'];

        if (file_exists("$dir.$gid")){
            $aria2->remove($gid);
            exec("rm -r '$dir'");
            unset($locations[$gid]);
            unlink("$dir.in_progress");
            unlink("$dir.$gid");
            continue;
        }

        $amount_done = $result['completedLength'];
        $total = $result['totalLength'];
        $percent = round($amount_done / $total, 2) * 100;

        if ($percent == 100){
            exec("chown -R www-data:www-data '$dir'");
            remove_non_av($dir, $locations[$gid]);
            unset($locations[$gid]);
            $aria2->remove($gid); 
            exec("rm -r '$dir'");
            continue;
        }

        if (file_exists("$dir.in_progress") && $percent >= 25){
            $file_contents = file_get_contents("$dir.in_progress");
            $file_contents = explode("\n", $file_contents);
            $location = $file_contents[1];
            $locations[$gid] = $location;
            unlink("$dir.in_progress");
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
                exec("mv '../.Partial/$object.start' '../.Partial/$object.in_progress'");
                $aria2->addUri(
                    [$file_contents[0]],
                    ['dir'=>"/var/www/media.bryceyoder.com/.Partial/$object",
                    'seed-time'=>0]);
            }

        }
    }
    sleep(5);
}

?>
