<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "quickbite";
$conn = new mysqli($servername, $username, $password, $dbname, 3307);
if($conn->connect_error){
    die("Connection Failed". $conn->connect_error);
}
?>