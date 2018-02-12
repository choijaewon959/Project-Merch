<?php

// Add Host Name or Domain name like : example.com
$db_host = "localhost";
// Add Database Name
$db_name = "short";
// Add Database Username
$db_user = "root";
// Add Databse password
$db_pass = "";

try{

  $db_con = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_pass);
  $db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
  echo $e->getMessage();
}
?>
