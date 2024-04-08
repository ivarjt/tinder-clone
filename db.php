<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "tinder_clone"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* 
Users table info:
id
username
email
password
age
bio
gender



*/



?>
