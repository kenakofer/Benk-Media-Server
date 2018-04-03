<?php
function list_dirs() {
//List all directories in a location
    $files = array_filter(glob('*'), 'is_dir');
    foreach($files as $file) {
        $file_orig = $file;
        $file = str_replace("~"," ",$file);
        echo "<div class='box-container'>
                <div class='box-del' id='./?boxdel=".$file_orig."'>X</div>";
        if ($file == "Movies"){
            echo "<a id='dbmo' class='dir-box' href='./".$file_orig."/'>$file</a>";
        } else if ($file == "TV") {
            echo "<a id='dbtv' class='dir-box' href='./".$file_orig."/'>$file</a>";
        } else if ($file == "Music") {
            echo "<a id='dbmu' class='dir-box' href='./".$file_orig."/'>$file</a>";
        } else {echo "<a class='dir-box' href='./".$file_orig."/'>$file</a>";}
        
        echo "</div>";
    }
}

function list_files() {
//List all files in a location
    $files = array_diff(scandir('.'), array('.','..','index.php'));
    if (empty($files)){
        echo "<h3 style='text-align:center;'>There's nothing here! Why not add some files?</h3>";
        return;
    }
    $vid_id = 0;
    foreach($files as $file) {
        if (is_file($file)){
            $file = str_replace('~',' ',$file);
            {
                $vid_id += 1;
                echo "<div id='vid$vid_id' class='video-container'></div>
                        <div class='item-container'>
                        <a class='item-del' href='?itemdel=".$file."'>X</a>
                        <div class='item-ren'>A</div>
                        <div onclick='play($vid_id, this.innerHTML)' class='file-item' >".$file."</div>
                      </div>";
            }
        }
    }
}

function create_dir($dir_name) {
    $dir_name = str_replace(" ", "~", $dir_name);
    mkdir('./'.$dir_name, 0777, true);
    copy('./index.php', './'.$dir_name.'/index.php');
}

function change_name($file, $name){
    $file = str_replace(' ','~',$file);
    $name = str_replace(' ','~',$name);
    $path = array_slice(explode('/',$file), 0, -1);
    $path = implode('/',$path).'/'.$name;
    rename('.'.$file, '.'.$path);
}

function add_file($files, $file_name) {
//Upload a file via the browser
    foreach ($files['name'] as $f => $name){
        error_log($name);
        error_log($f);

        if ($file_name == ""){
            $new_file_name = $name;
        } else {$new_file_name = $file_name;}

        $imageFileType = strtolower(pathinfo($name,PATHINFO_EXTENSION));
        $target_file = "./".$new_file_name.".".$imageFileType;
        $file_upload = 1;
    
        //Check if already exists
        if (file_exists($target_file)) {
            echo "<div class='notify'>Sorry, file already exists.</div>";
            $file_upload = 0;
        }
    
        //Verify that the file is audio or video
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $files['tmp_name'][$f]);
        if (!(strpos($mime, 'video') !== false) && !(strpos($mime, 'audio') !== false)) {
            $file_upload = 0;
            echo "<div class='notify'>This server only supports audio and video files.</div>"; 
        }
    
        if ($file_upload == 1) {
            if (move_uploaded_file($files["tmp_name"][$f], $target_file)){
                echo "<div class='notify'>Your file was uploaded successfully!</div>";
            }
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
                <div style='margin-top:10px;'></div>
          </a>";
    //Get the current URI as a string and split it by /, so you get each page individually
    $url = $_SERVER["REQUEST_URI"];
    if($url != '' && $url != '/'){
        $b = '';
        $links = explode('?',$url);
        $links = explode('/',rtrim($links[0],'/'));
        $count = count($links);
        foreach($links as $index => $l){
            $b .= $l;
            if (--$count <= 0){
                break;
            }
            if (substr($b, -1) == '/' || $index == 0){

                $b .= '/';
                continue;
            }
            $margin = strlen($l) * 7;
            if ($margin > 75){
                $margin = "style='margin-right:".($margin/2)."px;margin-left:".$margin."px;'";
            }
            $l_repl = str_replace("~"," ",$l);
            echo "<a $margin class='bc_c' href='".$b."/'>
                        <div class='breadcrumb'></div>
                        <div class='breadcrumb-title'>".$l_repl."</div>
                  </a>";
            $b .= '/';
        }
    }
}
if (isset($_POST['dest'])){
    if (count(explode("/", $_POST['source'])) > 2){
        $end_dest = end(explode("/", $_POST['source']));
    } else {$end_dest = $_POST['source'];}

    rename('.'.$_POST['source'],'.'.$_POST['dest'].'/'.$end_dest);
}
if (isset($_POST['file_q'])){
   change_name($_POST['file_q'], $_POST['name_q']); 
}
?>
