<!doctype html>
<html>
    <head>
        <title>Photobooth</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include('server.php');?>
        <div class="main-header">
            <h2>CAMERA</h2>
            <button onclick="logout();" style="float: right;">logout</button><br>
            <button onclick="home();" style="float: right;">home</button><br>
            <?php echo "You look amazing!";?>
        </div>
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
            <img id="photo" src="images/your_photo_here.png" width="400" height="300" alt="Image" download="file.png">
            <a href="#" id="download" class="frame-capture-button" download="my-file-name.png">Save</a>
        </div>
        <div id="status"></div>
        <script src="photo.js"></script>
        <script>
        function logout(){
            location.replace("logout.php?logout=1");
        }
        function home(){
            location.replace("index.phtml");
        }
        </script>
    </body>
</html>