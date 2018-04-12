<?php
function search($dir, $term, $arr){
    $objects = scandir($dir);
    $results = $arr;
    foreach ($objects as $object) {
        if ($object != '.' && $object != '..' && $object != '.Fonts' && $object != '.Images' && $object != '.git' && $object != '.Scripts' && $object != '.Partial' && strpos($object, '.php') !== true){
            if (is_file("$dir/".$object)){
                if (strpos(strtolower("$dir/".$object), strtolower($term))){
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, "$dir/".$object);
                    if (!(strpos($mime, 'video') !== false) && !(strpos($mime, 'audio') !== false)) {
                        continue;
                    } else {
                    array_push($results, array($object, "$dir/".$object)); 
                    }
                }
            } else {$results = search("$dir/".$object, $term, $results);}
        }
    }
    return $results;
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Benk Media Server</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"> 
    <link rel="stylesheet" href="/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src=".Scripts/add.js"></script>
    <script src=".Scripts/tor.js"></script>
</head>
<body>
    <form class='search-form' action='search.php' >
        <input type='text' name='search'><br /><br />
        <input type='submit' value='Search'></form>
    <div class='search-button'></div><br />
    <a id="bch" class="bc_c" href="/">
    <div id='dbc' class="breadcrumb">
        <img style="width:70%;transform:rotate(-45deg);margin-top:6px;margin-left:5px;"src="/.Images/home.svg">
    </div>
    </a>
    <h1 style='padding-left:50px;'>Search Results</h1>

<?php 
if(isset($_GET['search'])){
    echo "<div class='file-container'>";
   $results = search('.',$_GET['search'],array());
   $vid_id = 0;
   foreach ($results as $result){
        $file_new = str_replace('~',' ',$result[0]);
        $file_new = explode(".",$file_new);
        array_pop($file_new);
        $file_new = implode(".",$file_new);
        $vid_id += 1;
        echo "<div id='vid$vid_id' class='video-container'></div>
                <div class='item-container'>
                <div onclick='play($vid_id, \"$result[1]\", \"path\")' class='file-item' >".$file_new."</div>
              </div>";
   }
   echo "</div>";
}
?>
</body>
</html>
