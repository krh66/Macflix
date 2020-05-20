<?php  
// connecting databas
ob_start(); // Turns on output buffering
session_start();

date_default_timezone_set("Asia/Taipei");

try{
    $con = new PDO("mysql:dbname=macflix;host=localhost", "root", ""); //php data object, username = root, pswd = ""
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e){
    exit("Connection failed: " . $e->getMessage());
}
?>