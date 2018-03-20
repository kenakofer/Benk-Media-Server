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
    }
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
        exec('sudo aria2c -d ..'.$site.'/ --seed-time=0 '.$choice);
    }
}

if (isset($_POST['search_q'])){
    echo get_results($_POST['search_q']);
}
if (isset($_POST['grab_q'])){
    echo grab_dl($_POST['grab_q'], $_POST['grab_l']);
}
?>
