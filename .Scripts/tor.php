<?php
function get_results($query){
    $html = file_get_contents('https://thepiratebay.org/search/'.$query.'/0/99/0');
    $doc = new DOMDocument();
    if(!empty($html)){
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        $links = $xpath->query('//a[@class="detLink"]');
        if($links->length > 0){
            $inject = "";
            foreach ($links as $link){
                $link = $link->textContent;
                $inject = $inject.'<div onclick="grab_dl(this.innerHTML)" class="result">'.$link.'</div>'; 
            }
        } else { echo 'No results found!'; }
        echo $inject;
    } else {echo "<div style='margin-top:150px;'>Could not load download list: website not responding</div>";}
}

function grab_dl($title, $site){
    $html = file_get_contents('https://thepiratebay.org/search/'.$title.'/0/99/0');
    $doc = new DOMDocument();
    if(!empty($html)){
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        $links = $xpath->query('//a[@title="Download this torrent using magnet"]/@href');
        if($links->length > 0){
            $choice = $links[0]->nodeValue;
        } else { echo 'No results found!'; }
        $title = str_replace(" ",".",$title);
        //$file = fopen("../.Partial/$title.benk", 'w');
        //fclose($file);
        mkdir("../.Partial/$title");
        exec('sudo aria2c -d ../.Partial/'.$title.' --seed-time=0 '.$choice." & echo $! >> ../.Partial/$title.benk");
        exec("sudo chown -R www-data:www-data ../.Partial/$title");
        remove_non_av("../.Partial/$title");
        copy_index("../.Partial/$title");
        exec("mv ../.Partial/$title ..$site");
        unlink("../.Partial/$title.benk");
    } 
}
function copy_index($dir){
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

if (isset($_POST['search_q'])){
    echo get_results($_POST['search_q']);
}
if (isset($_POST['grab_q'])){
    echo grab_dl($_POST['grab_q'], $_POST['grab_l']);
}
?>
