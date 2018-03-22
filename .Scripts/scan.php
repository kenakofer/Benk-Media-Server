<?php
while (True){
    $files = array_diff(scandir('../.Partial/'), array('.','..','index.php'));
    foreach ($files as $file){
        if (is_file("../.Partial/$file")){
            $fp = fopen("../.Partial/$file", 'r');
            fseek($fp, -100, SEEK_END);
            $data = fread($fp, 200);
            if (!strpos($data, '%') !== false && $data != ""){
               exec("pkill -f ".substr($file, 0, -5)); 
            }
            fclose($fp); 
        }
    }
    sleep(10);
}
?>
