<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization");
 
// untuk menjadikan file php jadi format json
header("Content-Type: application/json");
 
$host="localhost";
$user="root";
$pass="";
$db="pengurus";
 
$con=mysqli_connect($host,$user,$pass,$db);
 
?>