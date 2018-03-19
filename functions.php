<?php
function list_dirs() {
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
    $files = array_diff(scandir('.'), array('.','..','index.php'));
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
    $imageFileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
    $target_file = "./".$file_name.".".$imageFileType;
    $file_upload = 1;

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $file_upload = 0;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    if (!(strpos($mime, 'video') !== false) && !(strpos($mime, 'audio') !== false)) {
        $file_upload = 0;
        echo "This server only supports audio and video files."; 
    }

    if ($file_upload == 1) {
        if (move_uploaded_file($file["tmp_name"], $target_file)){
            echo "Your file was uploaded successfully!";
        }
    }

}
function removedir($dir){
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
    echo "<a id='bch' class='bc_c' href='/'>
                <div class='breadcrumb'></div>
                <div style='margin-top:10px;'>Home</div>
          </a>";
    $url = $_SERVER["REQUEST_URI"];
    if($url != '' && $url != '/'){
        error_log('ah');
        $b = '';
        $links = explode('/',rtrim($url,'/'));
        foreach($links as $index => $l){
            $b .= $l;
            if ($index == 0){
                $b .= '/';
                continue;
            }
            echo "<a class='bc_c' href='".$b."/'>
                        <div class='breadcrumb'></div>
                        <div >".$l."</div>
                  </a>";
            $b .= '/';
        }
    }
}
?>
