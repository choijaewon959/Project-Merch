

<?php
session_start();
require_once('class.user.php');
$user = new USER();

if($user->is_loggedin()!="")
{
	$user->redirect('Buypage_loggedin.php');
}

if(isset($_POST['btn-signup']))
{
	$uname = strip_tags($_POST['txt_uname']);
	$umail = strip_tags($_POST['txt_umail']);
	$upass = strip_tags($_POST['txt_upass']);
  $phone_num = strip_tags($_POST['txt_phone_num']);

	if($uname=="")	{
		$error[] = "<b><font color='red'>provide username !</font></b>";
	}
	else if($umail=="")	{
		$error[] = "<b><font color='red'>provide email id !";
	}
	else if(!filter_var($umail, FILTER_VALIDATE_EMAIL))	{
	    $error[] = "<b><font color='red'>Please enter a valid email address !</font></b>";
	}
	else if($upass=="")	{
		$error[] = "<b><font color='red'>provide password !</font></b>";
	}
	else if(strlen($upass) < 6){
		$error[] = "<b><font color='red'>Password must be atleast 6 characters</font></b>";
	}
	else if(strlen($phone_num) < 7){
		$error[] = "<b><font color='red'>Phone number must be atleast 8 characters</font></b>";
	}
	else if(strlen($phone_num) >13){
		$error[] = "<b><font color='red'>Phone number must be less than 12 characters</font></b>";
	}
	else
	{
		try
		{
			$stmt = $user->runQuery("SELECT user_name, email FROM users WHERE user_name=:uname OR email=:umail");
			$stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
			$row=$stmt->fetch(PDO::FETCH_ASSOC);

			if($row['user_name']==$uname) {
				$error[] = "<b><font color='red'>sorry username already taken !</font></b>";
			}
			else if($row['email']==$umail) {
				$error[] = "<b><font color='red'>sorry email id already taken !</font></b>";
			}
			else
			{
				if($user->register($uname,$umail,$upass,$phone_num)){
<<<<<<< HEAD
					$user->redirect('Buypage_loggedin.php?joined');
=======
					$user->redirect('log_in.php?joined');
>>>>>>> 106bf21f73ecb50ae742d502723e06ed955c163d
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Sign in</title>
  <link rel="stylesheet" type="text/css" href="../css/sign_in.css">
  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
</head>
<body>

  <div class="tm-container">
    <div class="box">
      <div class="boxbody">
  				<div class="sayHi">
  						HOLA!</br>
              Make New Account!
  				</div>
  				<div class="facebookDiv">
  						<button id="facebookButton">Login with Facebook</button>
  				</div>
        <form method="post" >
            <?php
			if(isset($error))
			{
			 	foreach($error as $error)
			 	{
					 ?>
                     <div class="alert alert-danger">
                        <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
                     </div>
                     <?php
				}
			}
			else if(isset($_GET['joined']))
			{
				 ?>
                 <div class="alert alert-info">
                      <i class="glyphicon glyphicon-log-in"></i> &nbsp; Successfully registered <a href='index.php'>login</a> here
                 </div>
                 <?php
			}
			?>
      <div class="Username_panel">
        <input id="username" type="text" class="form-control" name="txt_uname" placeholder="username" value="<?php if(isset($error)){echo $uname;}?>" />
      </div>
      <div class="Email_panel">
        <input id="email" type="text" class="form-control" name="txt_umail" placeholder="e-mail" value="<?php if(isset($error)){echo $umail;}?>" />
      </div>
      <div class="PW_panel">
        <input id="password" type="password" class="form-control" name="txt_upass" placeholder="password"/>
      </div>
      <div class="PhoneNumber_panel">
        <input id="phonenumber" type="text" class="form-control" name="txt_phone_num" placeholder="phone number" value="<?php if(isset($error)){echo $uname;}?>" />
      </div>
      <div class="SignUp_panel">
        <input id="signup" value="Create Account" type="submit" class="button" name="btn-signup">
      </div>

        <div class="haveAccount">
            <p>Have an account ? <a href="log_in.php">Log In</a></p>
        </div>
        </form>
      </div> <!--boxbody-->
    </div><!--box-->
  </div><!--tm-container-->



</div>

</body>
</html>
