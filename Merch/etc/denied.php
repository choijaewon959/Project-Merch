<?php
	session_start();
	require_once("../php/class.user.php");
	$login = new USER();
	if($login->is_loggedin()!="")
	{
		$login->redirect('Buypage.php');
	}

	if(isset($_POST['btn-login']))
	{
		$uname = strip_tags($_POST['txt_uname_email']);
		$umail = strip_tags($_POST['txt_uname_email']);
		$upass = strip_tags($_POST['txt_password']);

		if($login->doLogin($uname,$umail,$upass))
		{
			$login->redirect('Buypage.php');
		}
		else
		{
			$error = "Wrong Details !";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Access Denied</title>
<link rel="stylesheet" href="style.css" type="text/css"  />
<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../css/Denied.css">

</head>
<body>



	<div id="main">

				<div id="denyDiv">
					<div class="box">
						<div class="boxbody">
							<div class="Logo">
								<div id="merchText">
									<a href="index.php">Merch</a>
									<div id="errorTextDiv">Error</div>
								</div><!--merchText-->

								<div id="messageDiv">
									<div id="message">
										Oops! 
										<a id="loginText" href="../php/log_in.php" >Login</a>
										first

									</div>
									
								</div>

							</div><!--logo-->
						</div><!--boxbody-->
						
					</div><!--box-->
						
				</div><!--denyDiv-->
    </div><!--main-->







</body>
</html>
