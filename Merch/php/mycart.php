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

  $stmt = $auth_user->runQuery("SELECT cart_id FROM mycart WHERE user_id=:uid AND product_id=:pid");
  $stmt->bindparam(":uid", $_SESSION['user_session']);
  $stmt->bindparam(":pid", $pid['product_id']);
  $stmt->execute();
  if($stmt->fetch(PDO::FETCH_ASSOC)){}
  else
  {
    $stmt = $auth_user->runQuery("INSERT INTO mycart(user_id, product_id) VALUES(:uid, :pid)");
    $stmt->bindparam(":uid", $_SESSION['user_session']);
    $stmt->bindparam(":pid", $pid['product_id']);
    $stmt->execute();
  }
  return $stmt;
?>
