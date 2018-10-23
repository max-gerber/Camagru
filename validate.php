<?php
include('server.php');
if (isset($_GET['token'])){
    $token = $_GET['token'];
    $query = "update users validated status='1' where token='$token'";
    if ($connction->query($query)){
        header("Location:index.php?success=Account Activated");
        exit();
    }
}
?>