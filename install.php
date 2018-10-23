<?php
    $servername = "localhost";
    $username = "root";
    $dbname = "camagru_db";
    $password = "12345Max";
    $connection = new mysqli($servername, $username, $password);
    if ($connection->connect_error){
        die("Connection failed: " . $connection->connect_error);
    } 
    $sql = "CREATE DATABASE $dbname";
    if ($connection->query($sql) === TRUE){
        echo "Database created successfully";
    } else{
        echo "Error creating database: " . $connection->error;
    }
    try{
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        verified TINYINT(1) NOT NULL DEFAULT '0',
        token VARCHAR(255) DEFAULT NULL,
        password VARCHAR(255)
        )";
        $connection->exec($sql);
        echo "Table users created successfully";
        }
    catch (PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
?>