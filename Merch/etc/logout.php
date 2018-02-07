<?php
	require_once('session.php');
	require_once('../4. MakeAccount/class.user.php');
	$user_logout = new USER();

	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('../2. Buy/Buypage.php');
	}
	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('../4. MakeAccount/login_page.php');
	}
