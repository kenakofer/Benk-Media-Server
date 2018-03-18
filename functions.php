<?php
function list_dirs() {
    $files = array_filter(glob('*'), 'is_dir');
    foreach($files as $file) {
        echo "<a href='./".$file."/'>
                  <div class='dir-box' >
                      <div class='dir-box-icon'></div>
                      $file
                  </div>
              </a>";
    }
}
function list_files() {
    $files = array_diff(scandir('.'), array('.','..','index.php'));
    foreach($files as $file) {
        if (is_file($file))
        {
            echo "<a href='".$file."'>".$file."</a> <br />";
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

    echo $mime;
    if ($file_upload == 1) {
        if (move_uploaded_file($file["tmp_name"], $target_file)){
            echo "Your file was uploaded successfully!";
        }
    }

}
?>
