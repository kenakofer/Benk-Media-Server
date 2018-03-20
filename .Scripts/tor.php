<?php
    set_time_limit(30);
    $html = file_get_contents('https://thepiratebay.org/search/'.$_GET['search_q'].'/0/99/0');
    $doc = new DOMDocument();
    if(!empty($html)){
        $doc->loadHTML($html);
        $xpath = new DOMXPath($doc);
        $links = $xpath->query('//a[@title="Download this torrent using magnet"]/@href');
        if($links->length > 0){
            $choice = $links[0]->nodeValue;
            echo $choice;
        } else { echo 'No results found!'; }
        exec('sudo aria2c -d . '.$choice);
        //exec('ping 198.51.243.100');
        //exec('sudo touch blarg.php');
    }
?>
