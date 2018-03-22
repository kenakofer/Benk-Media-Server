<?php 
    $dir = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $functions = $_SERVER['DOCUMENT_ROOT']."/functions.php"; 
    $del = 1;
    include_once($functions);
    if (!file_exists($_SERVER['DOCUMENT_ROOT'].$dir.'index.php')) {
        header('Location: /');
    }
    if (isset($_GET['dn']) && isset($_GET['d_type'])) {
        create_dir($_GET['dn']);
        header('Location: '.$dir);
    }
    if (isset($_POST["fn"])){
       add_file($_FILES["uf"],$_POST["fn"]); 
       $del = 0;
    }
    if (isset($_GET['itemdel'])) {
        unlink('./'.$_GET['itemdel']);
        header('Location: '.$dir.'?del=1');
    }
    if (isset($_GET['boxdel'])) {
        removedir($_GET['boxdel']);
        header('Location: '.$dir);
    }
    if (isset($_GET['del']) && $del == 1) {
        echo "<div class='notify'>Your file was deleted successfully.</div>";
    }
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
    <script src="/.Scripts/tor.js"></script>
</head>
<body>
    <?php
        if ($dir != "/"){
            echo "<div class='breadcrumbs'>";
                            breadcrumbs();
            echo "<a href='..'>
                    <div class='back'>
                    <div class='triangle'>
                </div></div></a>
            </div>";
            echo "<h1 style='padding-top:50px;'>".basename(__DIR__)."</h1>";
        }
        
    ?>
    <div class="dir-container">
        <?php 
            list_dirs(); 
        ?>
    </div>
    <div class="file-container">
        <?php
            if ($dir != "/"){
                list_files();
            }
        ?>
    </div>
    <div class="menu-container">
        <div class="new-menu">
            <ul>
                <li id='cnd'> Create new directory </li> 
                <?php if ($dir != "/"){
                    echo "<li id='dnf'> Download new </li>
                    <li id='um'> Upload media </li>";
                }?>
            </ul>
        </div>
        <a href="/downloads.php" class="dl-button">
            <img style='width:60%;margin-top:8px;' src='/.Images/dl.svg' />
        </a>
        <div class="new-button">
            <img style='margin-left:15px;margin-top:15px;width:60%;height:60%;' src='/.Images/plus.png' />
        </div>
    </div>
    <?php if ($dir != "/"){ echo "
    <div class=\"dnf_container\">
        <div class=\"dnf\">
            <div id='dnfc' class=\"close\">X</div>
            <div class='t-chooser'>
                <div id='tc1' class='t-choice t-choice-active'></div>
                <div id='tc2' class='t-choice'></div>
            </div>
            <h2>Download New Media</h2>
            <h3>Title</h3>
            <input type=\"text\" name=\"dn\" id=\"dn\"><br />
            <button id='dnb' onclick=\"get_results()\" >Search</button> 
            <div id='result_container'>
            </div>
        </div>
    </div>
    <div class=\"um_container\">
        <div class=\"um\">
            <div id='umc' class=\"close\">X</div>
            <h2>Upload Media</h2>
            <form id=\"um_form\" method=\"post\" enctype=\"multipart/form-data\">
                <h3>File Name</h3>
                <input type=\"text\" name=\"fn\"><br>
                <h3>Upload File</h3>
                <div class=\"fsubmit\">
                    <input type=\"file\" name=\"uf\">
                </div>
                <input type=\"submit\" value=\"Submit\">
            </form>
        </div>
    </div>";}?>
    <div class="cnd_container">
        <div class="cnd">
            <div id='cndc' class="close">X</div>
            <h2>Create New Directory</h2>
            <form id="cnd_form">
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
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
