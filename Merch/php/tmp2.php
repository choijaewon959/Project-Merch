<?php
  session_start();
  require_once("class.user.php");
  $auth_user = new USER();
  $counter = 0 ;
  $product_list = array();
  $quality = $_POST['q_value'];
  $category = $_POST['c_value'];
  $query = "SELECT * FROM sell_product";
  if ($quality !== "default")
  {
    $query .= "WHERE quality=".$quality;
  }
  if ($category !== "default")
  {
    $query .= "WHERE category=".$category;
  }
  print_r("query =");
  print_r($query);
  $product_stmt = $auth_user->runQuery($query);
  while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
    $counter = $counter +1 ;
  }
  $product_num = sizeof($product_list)-1;
  $product_list = array_slice($product_list,0,$product_num);
  if ($product_num !== 0)
  {

  }
  else
  {
    echo "<h3 align 'center'>No product found </h3> ";
  }
?>
