<?php
session_start();
require_once("class.user.php");
$login = new USER();

if($login->is_loggedin()!="")
{
	$login->redirect('/Project/php/Buypage_loggedin.php');
}

if(isset($_POST['btn-login']))
{
	$uname = strip_tags($_POST['txt_uname_email']);
	$umail = strip_tags($_POST['txt_uname_email']);
	$upass = strip_tags($_POST['txt_password']);

	if($login->doLogin($uname,$umail,$upass))
	{
		$login->redirect('Buypage_loggedin.php');

	}
	else
	{
		$error = "<b><font color='red'>Wrong Details !</font></b>";
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
<title>Log In</title>
</head>
<body>

<div class="tm-container">
  <div class="box">
    <div class="boxbody">
				<div class="Logo">
					<div id="merchText">
						<a href="">Merch</a>
					</div>
				</div>
					<div class="facebookDiv">
						 <button id="facebookButton">Login with Facebook</button>
					</div>
	        <form  method="post" action="log_in.php">
	              <?php
	      			if(isset($error))
	      			{
	      				      ?>
	                         <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
	                      <?php
	      			}
	      		    ?>
	            <div class="ID">
								<label id="usernameLabel">
										Username
								<label>
	              <input id="username" type="text" name="txt_uname_email" placeholder="Username or email" required />
	            </div>
	            <div class="PW">
								<label id="passwordLabel">
										Password
								<label>
	              <input id="password" type="password"  name="txt_password" placeholder="Your Password" />
	            </div>
	            <div class="DONE">
	              <input id="submitButton" value="Log in" type="submit" name="btn-login" class="button">
	            </div>
	        </form>
					<div class="SIGNUP">
						<a href="sign_in.php" id="signupButton">Sign Up</a>
					</div>

					<div class="forgotPW">
						<a href="forgotpassword.php">Forgot password?</a>
					</div>

      </div><!--boxbody-->
    </div><!--box-->
</div><!--tm-container-->

</body>
</html>
