<?php
if (!isset($_SESSION)){
    session_start();
}
$servername = "localhost";
$ad_username = "root";
$ad_password = "12345Max";
$dbname = "camagru_db";
$username = "";
$email = "";
$errors = array();

//  Registering

try{
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
        if (empty($username)){
            array_push($errors, "Username is required");
        }
        if (empty($email)){
            array_push($errors, "Email is required");
        }
        if (empty($password)){
            array_push($errors, "Password is required");
        }
        if (strlen($username) > 25){
            array_push($errors, "Usernames may not exeed 25 characters");
        }
        if (preg_match( '/[<>]/', $username)){
            array_push($errors, "Usernames may not contain '<' or '>' characters");
        }
        if (strlen($password) < 6){
            array_push($errors, "Passwords must be of 6 characters or more");
        }
        if (!preg_match( '/[A-Z]/', $password)){
            array_push($errors, "Passwords must contain at least one uppercase letter");
        }
        if (!preg_match( '/[a-z]/', $password)){
            array_push($errors, "Passwords must contain at least one lowercase letter");
        }
        if (!preg_match( '/[0-9]/', $password)){
            array_push($errors, "Passwords must contain at least one number");
        }
        if ($password != $confirm){
            array_push($errors, "The two passwords do not match");
        }
        $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE username = :us3r OR email = :ema1l");
        $stmt->execute(["us3r"=>$username, "ema1l"=>$email]);
        $results = $stmt->fetchAll();
        if (sizeof($results) >= 1){
            array_push($errors, "Username/Email already in use");
        }
        if (count($errors) == 0){
            $password = hash('whirlpool', $password);
            $token = hash('whirlpool', "crap".$password);
            $stmt = $connection->prepare("INSERT INTO camagru_db.users (username, email, `password`, token) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username,$email, $password, $token]);
            $message = 'Hello '.$username.', here is the activation link http://127.0.0.1:8080/Camagru/validate.php?token='.$token;
            $message = wordwrap($message, 70);
            mail($email, 'Camagru Registration', $message);
            header('location: login.php');
        }
    }
}
catch (PDOException $e){
    echo $connection . "<br>" . $e->getMessage();
}

//  Logging out

if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['username']);
}

//  Sending password reset email

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
            $stmt = $connection->prepare("UPDATE camagru_db.users SET token=:t0ken WHERE username=:us3r");
            $stmt->execute(["t0ken" => $token, "us3r" => $username]);
            $message = 'follow this link http://127.0.0.1:8080/Camagru/new-password.php?token='.$token.' to reset yourt password';
            $message = wordwrap($message, 70);
            mail($email, 'Password reset', $message);
            header('location: login.php');
        }
        else{
            array_push($errors, "The username - email combination is invalid");
        }
    }
}

//  Logging in

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
                header('location: index.php');
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

// Modifying account settings

if (isset($_POST['account'])){
    $username = ($_POST['username']);
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $confirm = ($_POST['confirm']);
    if (empty($username) && empty($email) && empty($password) && !isset($_POST['notifications'])){
        array_push($errors, "At least one value must be modified");
    }
    if (!empty($username)){
        if (strlen($username) > 25){
            array_push($errors, "Usernames may not exeed 25 characters");
        }
        if (preg_match( '/[<>]/', $username)){
            array_push($errors, "Usernames may not contain '<' or '>' characters");
        }
    }
    if (!empty($password)){
        if (strlen($password) < 6){
            array_push($errors, "Passwords must by of 6 characters or more");
        }
        if (!preg_match( '/[A-Z]/', $password)){
            array_push($errors, "Passwords must contain at least one uppercase letter");
        }
        if (!preg_match( '/[a-z]/', $password)){
            array_push($errors, "Passwords must contain at least one lowercase letter");
        }
        if (!preg_match( '/[0-9]/', $password)){
            array_push($errors, "Passwords must contain at least one number");
        }
        if ($password != $confirm){
            array_push($errors, "The two passwords do not match");
        }
    }
    if(count($errors) == 0){
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
        $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE username = :us3r");
        $stmt->execute(["us3r"=>$_SESSION['username']]);
        $results = $stmt->fetchAll();
        if (sizeof($results) == 1){
            if (!empty($username)){
                $query = $connection->prepare("UPDATE camagru_db.users SET username= :us3r WHERE username = :s3ssion");
                $query->execute(["us3r"=>$username, "s3ssion"=>$_SESSION['username']]);
                $_SESSION['username']=$username;
            }
            if (!empty($password)){
                $password = hash('whirlpool', $password);
                $query = $connection->prepare("UPDATE camagru_db.users SET `password`= :passw0rd WHERE username = :s3ssion");
                $query->execute(["passw0rd"=>$password, "s3ssion"=>$_SESSION['username']]);
            }
            if (!empty($email)){
                $query = $connection->prepare("UPDATE camagru_db.users SET email= :ema1l WHERE username = :s3ssion");
                $query->execute(["ema1l"=>$email, "s3ssion"=>$_SESSION['username']]);
            }
            if (isset($_POST['notifications'])){
                $query = $connection->prepare("UPDATE camagru_db.users SET notifications=1 WHERE username = :s3ssion");
                $query->execute(["s3ssion"=>$_SESSION['username']]);
            }
            header('location: index.php');
        }
        else{
            array_push($errors, "There was an error, please try again");
        }
    }
}

//  Verifying user

if (isset($_GET['token'])){
    $token = $_GET['token'];
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $query = $connection->prepare("UPDATE camagru_db.users SET verified=1 WHERE token=:T0KEN");
    $query->execute(["T0KEN" => $token]);
}

//  Reseting password

if (isset($_POST['new'])){
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $token = $_SESSION['token'];
    if (empty($password)){
        array_push($errors, "Password is required");
    }
    if (strlen($password) < 6){
        array_push($errors, "Passwords must by of 6 characters or more");
    }
    if (!preg_match( '/[A-Z]/', $password)){
        array_push($errors, "Passwords must contain at least one uppercase letter");
    }
    if (!preg_match( '/[a-z]/', $password)){
        array_push($errors, "Passwords must contain at least one lowercase letter");
    }
    if (!preg_match( '/[0-9]/', $password)){
        array_push($errors, "Passwords must contain at least one number");
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
        $stmt = $connection->prepare("SELECT * FROM camagru_db.users WHERE token = :t0ken");
        $stmt->execute(["t0ken"=>$token]);
        $results = $stmt->fetchAll();
        if (sizeof($results) == 1){
            $query = $connection->prepare("UPDATE camagru_db.users SET password=:p4ssw0rd WHERE token = :t0ken");
            $query->execute(["p4ssw0rd" => $password, "t0ken"=>$token]);
            header('location: login.php');
        }
        else{
            array_push($errors, "There was an error, please try again");
        }
    }
}

//  Add camera photo to database

if (isset($_POST['submit_camera'])){
    $picture = $_POST['picture'];
    $username = $_SESSION['username'];
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $stmt = $connection->prepare("INSERT INTO camagru_db.photos (photo, user) VALUES (:p1ctur3, :us3r)");
    $stmt->execute(["p1ctur3"=>$picture ,"us3r"=>$username]);
    $stmt = $connection->prepare("UPDATE camagru_db.users SET photos = (photos + 1) WHERE username = :us3r");
    $stmt->execute(["us3r"=>$username]);
    header('Location: index.php');
}

//  Add uploaded photo to database

if (isset($_POST['submit-upload'])){
    $filename = $_FILES["picture"]["tmp_name"];
    if (!empty($filename)){
        $username = $_SESSION['username'];
        $base64 = 'data:image/png;base64,'.base64_encode(file_get_contents($filename));
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
        $stmt = $connection->prepare("INSERT INTO camagru_db.photos (photo, user) VALUES (:p1ctur3, :us3r)");
	    $stmt->execute(["p1ctur3"=>$base64 ,"us3r"=>$username]);
        $stmt = $connection->prepare("UPDATE camagru_db.users SET photos = (photos + 1) WHERE username = :us3r");
        $stmt->execute(["us3r"=>$username]);
        header('Location: index.php');
    }
    else {
        header('Location: camera.php');
    }
}

//  Likes and comments

if (isset($_POST['interaction'])){
    $comment = $_POST['comment'];
    $username = $_SESSION['username'];
    $photo = $_SESSION['id'];
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    if (isset($_POST['like'])){
        $stmt = $connection->prepare("UPDATE camagru_db.photos SET likes = (likes + 1) WHERE id = :1d");
        $stmt->execute(["1d"=>$photo]);
    }
    if (!empty($comment)){
        $query = $connection->prepare("INSERT INTO camagru_db.comments (`photo-id`, username, comment) VALUES (:1d, :us3r, :c0mment)");
        $query->execute(["1d"=>$photo ,"us3r"=>$username, "c0mment"=>$comment]);
        $statement = $connection->prepare("SELECT `user` FROM camagru_db.photos WHERE id = :1d");
        $statement->execute(["1d"=>$photo]);
        $results = $statement->fetch();
        $reciever = $results['user'];
        $request = $connection->prepare("SELECT `notifications`, `email` FROM camagru_db.users WHERE username = :us3r");
        $request->execute(["us3r"=>$reciever]);
        $results = $request->fetch();
        if ($results['notifications'] == '1'){
            $message = 'Hi '.$reciever.', '.$username.' has commented "'.$comment.'" on one of your photos.';
            $message = wordwrap($message, 70);
            mail($results['email'], 'New comment', $message);
        }
    }
    header('Location: index.php');
}

//  Deleting user photo

if (isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
    $stmt = $connection->prepare("SELECT `user` FROM `camagru_db`.`photos` WHERE id = :1d");
    $stmt->execute(["1d" => $id]);
    $user = $stmt->fetch();
    if ($user['user'] == $_SESSION['username']){
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $ad_username, $ad_password);
        $query = $connection->prepare("DELETE FROM `camagru_db`.`photos` WHERE id=:1d");
        $query->execute(["1d" => $id]);
    }
}
?>