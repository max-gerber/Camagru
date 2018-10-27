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
// 
try{
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        if (strlen($username) > 25){
            array_push($errors, "Usernames may not exeed 25 characters");
        }
        if (strlen($password) < 6){
            array_push($errors, "Passwords must by of 6 characters or more");
        }
        if($password != $confirm){
            array_push($errors, "The two passwords do not match");
        }
        $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE username = :us3r OR email = :ema1l");
        $stmt->execute(["us3r"=>$username, "ema1l"=>$email]);
        $results = $stmt->fetchAll();
        if (sizeof($results) >= 1){
            array_push($errors, "Username/Email already in use");
        }
        if(count($errors) == 0){
            $password = hash('whirlpool', $password);
            console.log($password) ;
            $token = hash('whirlpool', "crap".$password);
            $sql = "INSERT INTO camagru_db.users (username, email, `password`, token) 
                VALUES ('$username','$email', '$password', '$token')";
            $connection->exec($sql);
            $message = 'Hello '.$username.', here is the activation link http://127.0.0.1:8080/Camagru/validate.php?token='.$token;
            $message = wordwrap($message, 70);
            mail($email, 'Camagru Registration', $message);
            header('location: login.php');
        }
    }
}
catch(PDOException $e){
    echo $sql . "<br>" . $e->getMessage();
}
if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
}
if (isset($_POST['reset'])){
    $username = ($_POST['username']);
    $email = ($_POST['email']);
    if (empty($username)){
        array_push($errors, "Username is required");
    }
    if (empty($email)){
        array_push($errors, "Email address is required");
    }
    if(count($errors) == 0){
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
        $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE username = :us3r AND email = :ema1l");
        $stmt->execute(["us3r"=>$username, "ema1l"=>$email]);
        $results = $stmt->fetchAll();
        if (sizeof($results) == 1){
            $token = hash('whirlpool', $username."crap".$email);
            $query = $connection->prepare("UPDATE camagru_db.users SET token=:t0ken WHERE username=:us3r");
            $query->execute(["t0ken" => $token, "us3r" => $username]);
            $message = 'follow this link http://127.0.0.1:8080/Camagru/new-password.php and paste this into the "token" field '.$token;
            $message = wordwrap($message, 70);
            mail($email, 'Password reset', $message);
            header('location: login.php');
        }
        else{
            array_push($errors, "The username - email combination is invalid");
        }
    }
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
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
        $password = hash('whirlpool', $password);
        $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE username = :us3r AND password = :p4ssw0rd");
        $stmt->execute(["us3r"=>$username, "p4ssw0rd"=>$password]);
        $results = $stmt->fetchAll();
        if (sizeof($results) == 1){
            $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE username = :us3r AND verified = 1");
            $stmt->execute(["us3r"=>$username]);
            $results = $stmt->fetchAll();
            if (sizeof($results) == 1){
                $_SESSION['username'] = $username;
                $_SESSION['success'] = "You are logged in";
                header('location: index.phtml');
            }
            else{
                array_push($errors, "This account is unverified, check your emails");
            }
        }
        else{
            array_push($errors, "This username/password is invalid");
        }
    }
}
// 33b5c5a389b7a7f041a86e99fe5025c6909e86afae5e02f7997586a6bde9c285d4356ff61d59bb1172f367dcb9813e9082a22a70c3751b1bb7e28ba9bac8225a
// 33b5c5a389b7a7f041a86e99fe5025c6909e86afae5e02f7997586a6bde9c285d4356ff61d59bb1172f367dcb9813e9082a22a70c3751b1bb7e28ba9bac8225a
if (isset($_GET['token'])){
    $token = $_GET['token'];
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $query = $connection->prepare("UPDATE camagru_db.users SET verified=1 WHERE token=:T0KEN");
    $query->execute(["T0KEN" => $token]);
}
if (isset($_POST['new'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $token = $_POST['reset-token'];
    if (empty($username)){
        array_push($errors, "Username is required");
    }
    if (empty($email)){
        array_push($errors, "Email is required");
    }
    if (empty($password)){
        array_push($errors, "Password is required");
    }
    if (strlen($password) < 6){
        array_push($errors, "Passwords must by of 6 characters or more");
    }
    if($password != $confirm){
        array_push($errors, "The two passwords do not match");
    }
    if (empty($password)){
        array_push($errors, "Token is required");
    }
    if(count($errors) == 0){
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
        $password = hash('whirlpool', $password);
        $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE username = :us3r AND email = :ema1l AND token = :t0ken");
        $stmt->execute(["us3r"=>$username, "ema1l"=>$email, "t0ken"=>$token]);
        $results = $stmt->fetchAll();
        if (sizeof($results) == 1){
            $query = $connection->prepare("UPDATE camagru_db.users SET password=:p4ssw0rd WHERE username=:us3r");
            $query->execute(["p4ssw0rd" => $password, "us3r" => $username]);
            header('location: login.php');
        }
        else{
            array_push($errors, "This Username/Email/Token is incorrect");
        }

    }
}
?>