<?php
  session_start();
  require_once("class.user.php");
  $auth_user = new USER();
  $date = $_POST['dateKey'];
  $title = $_POST['titleKey'];
  $stmt = $auth_user->runQuery("SELECT product_id, seller_id FROM sell_product WHERE upload_date=:udate AND title =:utitle");
  $stmt->bindparam(":utitle", $title);
  $stmt->bindparam(":udate", $date);
  $stmt->execute();
  $pid = $stmt->fetch(PDO::FETCH_ASSOC);

  $stmt = $auth_user->runQuery("DELETE FROM sell_product WHERE product_id=:pid");
  $stmt->bindparam(":pid", $pid['product_id']);
  $stmt->execute();
  $stmt = $auth_user->runQuery("DELETE FROM mycart WHERE product_id=:pid");
  $stmt->bindparam(":pid", $pid['product_id']);
  $stmt->execute();
  return $stmt;
?>
