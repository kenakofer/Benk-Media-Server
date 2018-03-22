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

while(True){
//Runs continuously in background listening for download events
    $objects = scandir("../.Partial");
    foreach ($objects as $object) {
        if($object != '.' && $object != '..' && is_dir("../.Partial/$object")){
            //If torrent has finished downloading, chown the directory to www-data, run the above functions, and move it to the right location
            if (!file_exists("../.Partial/$object.in_progress")){
                $to_path = exec("head -1 ../.Partial/$object.done");
                exec('chown -R www-data:www-data ../.Partial/'.$object);
                remove_non_av("../.Partial/$object");
                copy_index("../.Partial/$object");
                exec("mv ../.Partial/$object ..$to_path");
                unlink("../.Partial/$object.done");
            }
            //If the file is set to be canceled, get the PID of the running aria2 process and kill it, then clean up the directory
            if (file_exists("../.Partial/$object.cancel")){
                $pid = exec("tail -1 ../.Partial/$object.done");
                $pid = $pid + 1;
                exec("kill $pid");
                unlink("../.Partial/$object.done"); 
                unlink("../.Partial/$object.cancel"); 
                unlink("../.Partial/$object.in_progress"); 
                exec("rm -r ../.Partial/$object");
            }
        }
    }
    sleep(10);
}

?>
