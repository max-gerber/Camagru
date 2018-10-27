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
            <video id ="video" width="400" height="300"></video>
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
            <canvas id ="canvas" width="400" height="300"></canvas>
            <img id="photo" src="image/your_photo_here.png" width="400" height="300" alt="Image">
        </div>
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