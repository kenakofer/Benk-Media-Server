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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/.Scripts/add.js"></script>
</head>
<body>
    <div class="dir-container">
        <?php 
            list_dirs(); 
        ?>
    </div>
    <div class="menu-container">
        <div class="new-menu">
            <ul>
                <li id='cnd'> Create new directory </li> 
                <li id='um'> Upload media </li>
            </ul>
        </div>
        <div class="new-button">
        </div>
    </div>
    <div class="cnd_container">
        <div class="cnd">
            <h1>Create New Directory</h1>
            <form action="" id="cnd_form">
                <h3>Directory Name</h3>
                <input type="text" name="dn"><br>
                <h3>Media Type</h3>
                <div class="selectbox">
                    <select name="d_type" form="cnd_form">
                        <option value="none">None</option>
                        <option value="movies">Movies</option>
                        <option value="music">Music</option>
                        <option value="tv">TV</option>
                    </select> <br /> 
                </div>
                <input type="submit" value="Submit">
            </form>
        <div>
    </div>
</body>
</html>
