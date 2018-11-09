<!doctype html>
<html>
    <?php include('server.php');?>
    <head>
        <title>CAMAGRU</title>
        <link rel="stylesheet" href="style.css">
        <div class="main-header">
            <h2>HOME PAGE</h2>
            <button onclick="logout();" style="float: right; margin-right: 125px;">Logout</button><br>
            <button onclick="account();" style="float: right; margin-right: 125px;">Account</button><br>
            <button onclick="home();" style="float: right; margin-right: 125px;">Home</button><br>
            <?php
                if (isset($_SESSION['username'])){
                    echo "Hello ".$_SESSION['username']."!";
                }
                else{
                    header('location: login.php');
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
        function home(){
            location.replace("index.php");
        }
        </script>    
    </head>
    <body>
        <div style="top:175px; position: relative; align:center;">
            <?php
                include('server.php');
                $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
                $stmt = $connection->prepare("SELECT `photo` FROM `camagru_db`.`photos` WHERE id = :1d ORDER BY creation DESC");
                $stmt->execute(["1d"=>$_GET['id']]);
                $results = $stmt->fetchAll();
                if (sizeof($results) != 1){
                    header('location: index.php');
                }
                $stmt = $connection->prepare("SELECT `photo` FROM `camagru_db`.`photos` WHERE id = :1d ORDER BY creation DESC");
                $stmt->execute(["1d"=>$_GET['id']]);
                $image = $stmt->fetch();
                echo('<img src ='.$image[photo].' class="center"/>');
            ?>
            <form method="post" action="server.php">
                <?php 
                    if (isset($_GET['id'])){
                        $_SESSION['id'] = $_GET['id'];
                    }
                ?>
                <div class="input-group">
                    <div>I like this!</div>
                    <input type="checkbox" name="like">
                </div>
                <div class="input-group">
                    <label>Write a comment!</label>
                    <input type="text" name="comment">
                </div>
                <div class="input-group">
                    <button type="submit" name="interaction" class="button">Submit</button>
                </div>
            </form>
            <?php
                include('server.php');
                $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
                $stmt = $connection->prepare("SELECT `likes` FROM `camagru_db`.`photos` WHERE `id` = :1d");
                $stmt->execute(["1d"=>$_SESSION['id']]);
                $likes = $stmt->fetch();
                echo("This photo has ".$likes[likes]." like(s).<br>");
                $stmt = $connection->prepare("SELECT `username`, `comment` FROM `camagru_db`.`comments` WHERE `photo-id` = :1d");
                $stmt->execute(["1d"=>$_SESSION['id']]);
                while ($comments = $stmt->fetch()) {
                    echo($comments[username].": ");
                    echo($comments[comment]."<br>");
                }
            ?>
            <div>
                <br><br>
            </div>
        </div>
    </body>
    <footer>
        <div class="main-header" style="position :fixed; bottom:0; left:0">
        </div>
    </footer>
</html>