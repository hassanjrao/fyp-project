<?php

$host="localhost";
$dbname="fyp_db";
$user="root";
$pass="";

// $host="localhost";
// $dbname="dj_project_db";
// $user="hsnrao";
// $pass='$V#75Hp25]f4';

$conn=new PDO ("mysql:host=$host;dbname=$dbname" ,$user,$pass);

  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>