<?php

	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome Home</title>
</head>
<body>



	<div id="main">

								<h1><font color='green'>Congratulation!</font></h1>

               <p><b>You can Access this Page.</b></br>
								<?php
										echo "id: ". implode(',',$userRow);
								 ?>
							 </p>



						<p><a href="logout.php?logout=true"  ><button class="button" >SIGN OUT</button</a></p>

        </div>







</body>
</html>
