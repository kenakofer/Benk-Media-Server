<?php 
    $functions = $_SERVER['DOCUMENT_ROOT']."/functions.php"; 
    include_once($functions);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Benk Media Server</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"> 
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="dir-container">
        <?php 
            list_dirs(); 
        ?>
    </div>
        <?php 
            list_files(); 
        ?>
</body>
</html>
