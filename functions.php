<?php
function list_dirs() {
//List all directories in a location
    $files = array_filter(glob('*'), 'is_dir');
    foreach($files as $file) {
        echo "<div class='box-container'>
                <a class='box-del' href='./?boxdel=".$file."'>X</a>
                <a class='dir-box' href='./".$file."/'>
                <div class='dir-box-icon'></div>$file</a>
            </div>";
    }
}

function list_files() {
//List all files in a location
    $files = array_diff(scandir('.'), array('.','..','index.php'));
    if (empty($files)){
        echo "<h3 style='text-align:center;'>There's nothing here! Why not add some files?</h3>";
        return;
    }
    foreach($files as $file) {
        if (is_file($file))
        {
            echo "<div class='item-container'>
                    <a class='item-del' href='?itemdel=".$file."'>X</a>
                    <a class='file-item' href='./".$file."'>".$file."</a>
                  </div>";
        }
    }
}

function create_dir($dir_name) {
    mkdir('./'.$dir_name, 0777, true);
    copy('./index.php', './'.$dir_name.'/index.php');
}

function add_file($file, $file_name) {
//Upload a file via the browser
    $imageFileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
    $target_file = "./".$file_name.".".$imageFileType;
    $file_upload = 1;

    //Check if already exists
    if (file_exists($target_file)) {
        echo "<div class='notify'>Sorry, file already exists.</div>";
        $file_upload = 0;
    }

    //Verify that the file is audio or video
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    if (!(strpos($mime, 'video') !== false) && !(strpos($mime, 'audio') !== false)) {
        $file_upload = 0;
        echo "<div class='notify'>This server only supports audio and video files.</div>"; 
    }

    if ($file_upload == 1) {
        if (move_uploaded_file($file["tmp_name"], $target_file)){
            echo "<div class='notify'>Your file was uploaded successfully!</div>";
        }
    }
}

function removedir($dir){
//Remove directories and contents recursively
    if(is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                (filetype($dir . '/' . $object) == 'dir') ? removedir($dir.'/'.$object):unlink($dir.'/'.$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function breadcrumbs(){
//Generate a breadcrumb naviagtion trail
    echo "<a id='bch' class='bc_c' href='/'>
                <div class='breadcrumb'>
                    <img style='width:70%;transform:rotate(-45deg);margin-top:6px;margin-left:5px;' src='/.Images/home.svg'></img>
                </div>
                <div style='margin-top:10px;'>Home</div>
          </a>";
    //Get the current URI as a string and split it by /, so you get each page individually
    $url = $_SERVER["REQUEST_URI"];
    if($url != '' && $url != '/'){
        $b = '';
        $links = explode('/',rtrim($url,'/'));
        foreach($links as $index => $l){
            $b .= $l;
            if (strpos($b, '?') !== False) {
                $b = explode('?', $b)[0];
                $l = explode('?', $l)[0];
            }
            if (substr($b, -1) == '/' || $index == 0){
                $b .= '/';
                continue;
            }
            echo "<a class='bc_c' href='".$b."/'>
                        <div class='breadcrumb'></div>
                        <div class='breadcrumb-title'>".$l."</div>
                  </a>";
            $b .= '/';
        }
    }
}
?>
