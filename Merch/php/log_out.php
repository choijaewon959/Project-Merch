<?php
	require_once('../etc/session.php');
	require_once('class.user.php');
	$user_logout = new USER();

	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('Buypage_needlog.php');
	}

	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('log_out.php');
	}
