<?php

$db_host = "localhost";
$db_name = "mydb";
$db_user = "root";
$db_pass = "";

try{

  $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
  $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $conDB = mysqli_connect($db_host, $db_user, $db_pass,$db_name)or
  die('Error: Could not connect to database.');
}
catch(PDOException $e){
  echo $e->getMessage();
}
?>
