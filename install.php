<?php
    $servername = "localhost";
    $username = "root";
    $dbname = "camagru_db";
    $password = "12345Max";
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    
    // Create database
    $sql = "CREATE DATABASE $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // sql to create table
        $sql = "CREATE TABLE users (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        verified TINYINT(1) NOT NULL DEFAULT '0',
        token VARCHAR(255) DEFAULT NULL,
        password VARCHAR(255)
        )";
    
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Table users created successfully";
        }
    catch(PDOException $e){
        echo $sql . "<br>" . $e->getMessage();
    }
//    $conn->close();
?>