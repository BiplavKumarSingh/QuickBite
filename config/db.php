<?php
// if (!isset($_SERVER['HTTP_REFERER'])) {
//     //redirect them if try to connect to config file
//     header('location:http://localhost/project1/QuickBite/');
//     exit;
// }
$host="localhost";
$user="root";
$pass="";
$db="aad";
$conn = new mysqli($host,$user,$pass);

if ($conn) {
    echo "Database server connect success<br/>";
    $sql="CREATE DATABASE quickbite";
    $result=  $conn->query($sql);
    if($result){
        echo "Database created successfully";
    }else{
        echo "Database creation failed";
    }
}else {
    echo "Database not connected";
}
?>