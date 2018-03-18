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
?>
