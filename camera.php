<!doctype html>
<html>
        <?php include('server.php');?>
    <head>
        <title>Photobooth</title>
        <link rel="stylesheet" href="style.css">
        <div class="main-header">
            <h2>CAMERA</h2>
            <button onclick="logout();" style="float: right; margin-right: 125px;">logout</button><br>
            <button onclick="home();" style="float: right; margin-right: 125px;">home</button><br>
            <?php echo "You look amazing!";?>
        </div>
    </head>
    <body>
        <div class="frame">
            <img id="live" class="overlay" width="400" height="300">
            <video id ="video" width="400" height="300"></video><br>
            <div>
                <a href="#" id="sticker1" class="button">Rainbow filter</a>
                <a href="#" id="sticker2" class="button">Mood filter</a>
                <a href="#" id="sticker3" class="button">Gothic filter</a>
                <a href="#" id="sticker4" class="button">Hipster filter</a>
            </div>
            <a href="#" id="capture" class="frame-capture-button">
                <?php
                    if (isset($_SESSION['username'])){
                        echo "Take your photo ".$_SESSION['username']."!";
                    }
                    else{
                        header('location: login.php');
                    }
                ?>
            </a>
            <input id="image-file" type="file" />
            <canvas id ="canvas" width="400" height="300"></canvas>
            <img id="photo" src="images/your_photo_here.png" width="400" height="300" alt="Image">
            <a href="#" id="download" class="frame-capture-button">Save</a>
        </div>
        <div id="status"></div>
        <?php
            include('server.php');
            $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
            $stmt = $connection->prepare("SELECT `photo`, `user` FROM `camagru_db`.`photos` WHERE `user`= :us3r");
            $stmt->execute(["us3r"=>$_SESSION['username']]);
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
        <script src="photo.js"></script>
        <script>
        function logout(){
            location.replace("logout.php?logout=1");
        }
        function home(){
            location.replace("index.php");
        }
        </script>
    </body>
    <footer>
        <div class="main-header" style="position :fixed; bottom:0; left:0">
        </div>
    </footer>
</html>