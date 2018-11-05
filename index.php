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
        function camera(){
            location.replace("camera.php");
        }
        function account(){
            location.replace("account.php");
        }
        </script>    
    </head>
    <body>
    <?php
        include('server.php');
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
        $stmt = $connection->prepare("SELECT `photo`, `user` FROM `camagru_db`.`photos`");
        $stmt->execute();
        echo '<div style="top:175px; position: relative; align:center;">';
        while ($row = $stmt->fetch()) {
            echo('<div class="gallery">');
            // echo('<a target="_blank">');
            echo("<img src =".$row[photo]." class='center'/>");
            // echo('</a>');
            echo('<div class="center">'.$row[user].'</div>');
            echo('</div>');
        }
        echo '<div> </br></br> </div>';
        echo "</div>";
    ?>
    </body>
    <footer>
        <div class="main-header" style="position :fixed; bottom:0; left:0">
        </div>
    </footer>
</html>