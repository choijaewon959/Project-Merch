<?php
  session_start();
  require_once("class.user.php");
  $auth_user = new USER();
  $title = $_POST['titleKey'];
  $stmt = $auth_user->runQuery("DELETE FROM mycart WHERE user_id=:uid AND title =:utitle");
  $stmt->bindparam(":uid", $_SESSION['user_session']);
  $stmt->bindparam(":utitle", $title);
  $stmt->execute();
  return $stmt;
?>
