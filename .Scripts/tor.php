<?php
function get_results($site, $query){
//Gets search results from one of two download providers by scraping their webpages
    error_log($site);
    if ($site == 'tc1'){
        $html = file_get_contents('https://thepiratebay.org/search/'.$query.'/0/99/0');
    }
    if ($site == 'tc2'){
        $html = file_get_contents('https://btdb.to/q/'.$query.'/?sort=popular');
    }
    $doc = new DOMDocument();
    if(!empty($html)){
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        if ($site == 'tc1'){
            $links = $xpath->query('//a[@class="detLink"]');
        }
        if ($site == 'tc2'){
            $links = $xpath->query('//h2[@class="item-title"]/a/@title');
        }
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

function grab_dl($tor_site, $title, $site){
//Initiates download from one of two providers by scraping their HTML
    $home = '/home/www-data';
    if ($tor_site == 'tc1'){
        $html = file_get_contents('https://thepiratebay.org/search/'.$title.'/0/99/0');
    }
    if ($tor_site == 'tc2'){
        $html = file_get_contents('https://btdb.to/q/'.$title.'/?sort=popular');
    }
    $doc = new DOMDocument();
    if(!empty($html)){
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        if ($tor_site == 'tc1'){
            $links = $xpath->query('//a[@title="Download this torrent using magnet"]/@href');
        }
        if ($tor_site == 'tc2'){
            $links = $xpath->query('//a[@class="magnet"]/@href');
        }
        if($links->length > 0){
            $choice = $links[0]->nodeValue;
        } else { echo 'No results found!'; }

        //Set up directory so scan.php can read it correctly
        $title = str_replace(" ",".",$title);
        mkdir("../.Partial/$title");
        exec("touch ../.Partial/$title.in_progress");
        exec("echo $site >> ../.Partial/$title.done");
        exec('sudo aria2c -d ../.Partial/'.$title.' --seed-time=0 "'.$choice."\" & echo $! >> ../.Partial/$title.done");
        unlink("../.Partial/$title.in_progress");
    } 
}

//Allow these functions to be called from tor.js
if (isset($_POST['search_q'])){
    echo get_results($_POST['site_q'], $_POST['search_q']);
}
if (isset($_POST['grab_q'])){
    echo grab_dl($_POST['tor_site_q'], $_POST['grab_q'], $_POST['grab_l']);
}
?>
