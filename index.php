<!doctype html>
<html>
    <?php include('server.php');?>
    <head>
        <title>CAMAGRU</title>
        <link rel="stylesheet" href="style.css">
        <div class="main-header">
            <h2>HOME PAGE</h2>
            <button onclick="logout();" style="float: right; margin-right: 125px;">
            <?php
                if (isset($_SESSION['username'])){
                    echo "Logout";
                }
                else{
                    echo "Login";
                }
            ?>
            </button><br>
            <button onclick="account();" style="float: right; margin-right: 125px;">
            <?php
                if (isset($_SESSION['username'])){
                    echo "Account";
                }
                else{
                    echo "Join";
                }
            ?>
            </button><br>
            <button onclick="camera();" style="float: right; margin-right: 125px;">Camera</button><br>
            <?php
                if (isset($_SESSION['username'])){
                    echo "Hello ".$_SESSION['username']."!";
                }
                else{
                    echo "Hello!";
                }
            ?>
        </div>
        <script>
        function logout(){
            location.replace("logout.php?logout=1");
        }
        function account(){
            location.replace("account.php");
        }
        function camera(){
            location.replace("camera.php");
        }
        </script>    
    </head>
    <body>
        <?php
            include('server.php');
            $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
            $stmt = $connection->prepare("SELECT `id`, `photo`, `user` FROM `camagru_db`.`photos` ORDER BY `id` DESC");
            $stmt->execute();
            $results = $stmt->fetchAll();
            $elements = sizeof($results);
            $pages = ceil($elements / 5);
            if (!isset($_GET['page'])){
                $current = 1;
            }
            else {
                $current = $_GET['page'];
            }
            $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
            $stmt = $connection->prepare("SELECT `id`, `photo`, `user` FROM `camagru_db`.`photos` ORDER BY `id` DESC LIMIT ".(($current - 1) * 5).", 5");
            $stmt->execute();
            echo('<div style="top:175px; position: relative; align:center;">');
                while ($row = $stmt->fetch()) {
                    echo('<div class="gallery">');
                        echo('<a href="http://127.0.0.1:8000/Camagru/social.php?id='.$row['id'].'">');
                            echo('<img src ='.$row['photo'].' class="center"/>');
                        echo('</a>');
                        echo('<div class="center">');
                            echo($row['user']);
                        echo('</div>');
                    echo('</div>');
                }
                for ($current = 1; $current <= $pages; $current++){
                    echo('<a href="index.php?page='.$current.'">'.$current.'</a>');
                }
                echo('<div>');
                    echo('</br></br>');
                echo('</div>');
            echo('</div>');
        ?>
    </body>
    <footer>
        <div class="main-header" style="position :fixed; bottom:0; left:0">
        </div>
    </footer>
</html>