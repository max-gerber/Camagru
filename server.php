<?php
session_start();
$servername = "localhost";
$ad_username = "root";
$ad_password = "12345Max";
$tablename = "camagru_db.users";
$tablename = "users";
$username = "";
$email = "";
$errors = array();
try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
        if(empty($username)){
            array_push($errors, "Username is required");
        }
        if(empty($email)){
            array_push($errors, "Email is required");
        }
        if(empty($password)){
            array_push($errors, "Password is required");
        }
        if($password != $confirm){
            array_push($errors, "Ther two passwords do not match");
        }
        $stmt = $conn->prepare("SELECT * FROM camagru_db.users WHERE username = :usr OR email = :eml");
        $stmt->execute(["usr"=>$username, "eml"=>$email]);
        $results = $stmt->fetchAll();
        if (sizeof($results) >= 1){
            array_push($errors, "Username/Email already in use");
        }
        if(count($errors) == 0){
            $password = hash('whirlpool', $password);
            console.log($password) ;
            $sql = "INSERT INTO camagru_db.users (username, email, `password`) 
                VALUES ('$username','$email', '$password')";
            $conn->exec($sql);
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are logged in";
            header('location: camera.html');
        }
    }
}
catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
    header('location:camera.html');
}
if (isset($_POST['login'])){
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    if (empty($username)){
        array_push($errors, "Username is required");
    }
    if (empty($password)){
        array_push($errors, "Password is required");
    }
    if(count($errors) == 0){
        
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password, $opt);
        $password = hash('whirlpool', $password);
        $stmt = $conn->prepare("SELECT * FROM camagru_db.users WHERE username = :usr AND password = :psw");
        $stmt->execute(["usr"=>$username, "psw"=>$password]);
        $results = $stmt->fetchAll();
        if (sizeof($results) == 1){
             $_SESSION['username'] = $username;
             $_SESSION['success'] = "You are logged in";
            header('location: camera.html');
             }
         else{
             array_push($errors, "The username/password provided is invalid");
             header('location: login.php');
         }
    }
}
?>