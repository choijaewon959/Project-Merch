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
		$login->redirect('home.php');
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
<title>Sign In</title>
</head>
<body>

<div id="main">




       <form  method="post" >

        <h1 >Sign In</h1>

        <?php
			if(isset($error))
			{
				?>

                   <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !

                <?php
			}
		?>



        <input type="text"  name="txt_uname_email" placeholder="Username or email" required />



        <input type="password"  name="txt_password" placeholder="Your Password" />



            <input value="SIGN IN" type="submit" name="btn-login" class="button">



            <p>Don't have account! <a href="sign_in.php">Sign Up</a></p>
      </form>



</div>

</body>
</html>
