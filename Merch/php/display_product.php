<?php
	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM book");
	$stmt->execute(array());
	$active_detail = $stmt->fetch(PDO::FETCH_ASSOC);
  echo json_encode($active_detail);

?>
