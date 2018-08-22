<?php
	session_start();
	require_once("class.user.php");
	$login = new USER();

	if($login->is_loggedin()!="")
	{
		$login->redirect('wemerch.hk/php/Buypage.php');
	}
	if(isset($_POST['submit_email']))
	{
		$umail = strip_tags($_POST['txt_uname_email']);
		if($login->checkEmail($_SESSION['send_email']))
		{
      $str = "1234567890!@#$%^&*";
			$str = str_shuffle($str);
			$str = substr($str, 0, 10);
			$stmt = $login->runQuery("UPDATE users SET token=:token WHERE email=:email");
			$stmt->bindparam(":token", $str);
			$stmt->bindparam(":email", $umail);
			$stmt->execute();
			$url = "wemerch.hk/php/resetpass.php?token=$str&email=$umail";
			if(mail($umail, "Merch - Reset Password URL", $url, "From: myemail@merch.com\r\n"))
			{
					$display = "Change url sent to the registered email";
			}
			else
			{
					$display = "nope";
			}
		}
		else
		{
			$display = "<b>User Email does not exist !</b>";
		}
	}
	?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	  <link rel="stylesheet" type="text/css" href="../css/log_in.css">
		<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
	<title>Find Password</title>
	</head>
	<body>

	<div class="tm-container">
	  <div class="box">
	    <div class="boxbody">
					<div class="Logo">
						<div id="merchText">
							<a href="index.php">Merch</a>
						</div>
					</div>
		        <form  method="post" action="findpass.php">

		            <div class="ID">
									<label id="usernameLabel">
											Email
									<label>
		              <input id="username" type="text" name="txt_uname_email" placeholder="Registered Email" required />
		            </div>
		            <div class="DONE">
		              <input id="submitButton" value="Send change email url" type="submit" name="submit_email" class="button">
		            </div>
		        </form>
						<div class="SIGNUP">
							<a href="sign_in.php" id="signupButton">Sign Up</a>
						</div>

						<div class="signin">
							<a href="log_in.php">Log in</a>
						</div>
						<?php
					if(isset($display))
					{
									?>
											 <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $display; ?>
										<?php
					}
						?>

	      </div><!--boxbody-->
	    </div><!--box-->
	</div><!--tm-container-->
	</body>
</html>
