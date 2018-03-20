<?php
$html = file_get_contents('https://thepiratebay.org/search/'.$argv[1].'/0/99/0');
$doc = new DOMDocument();
if(!empty($html)){
    $doc->loadHTML($html);
    $xpath = new DOMXPath($doc);
    $links = $xpath->query('//a[@title="Download this torrent using magnet"]/@href');
    if($links->length > 0){
        $choice = $links[0]->nodeValue;
    } else { echo 'No results found!'; }
}
//`echo "aria2c -d . --listen-port=6681 $choice"|at now`;
    exec('bash -c "exec nohup setsid aria2c -d . --listen-port=6681 '.$choice.' > /dev/null 2>&1 &"');
?>
