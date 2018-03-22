<?php
include_once(".Scripts/dashboard.php");
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Benk Media Server</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"> 
    <link rel="stylesheet" href="/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src=".Scripts/dashboard.js"></script>
</head>
<body>
    <h1>Downloads</h1>
    <?php get_dls(); ?>
</body>
</html>
    

