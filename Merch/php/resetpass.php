<?php
session_start();
require_once("class.user.php");
$login = new USER();

if(isset($_GET['token']) && isset($_GET['email']))
{
  $stmt = $login->prepare("SELECT user_id FROM users WHERE token =:token AND email=:email");
  $stmt->bindparam(":token", $_GET['token']);
  $stmt->bindparam(":email", $_GET['email']);
  $stmt->execute();
  $uid = $stmt->fetch(PDO::FETCH_ASSOC);
}
else
{
  header("Location: https://wemerch.hk/php/");
}
if(isset($_POST["new_pass"]))
{
  $currentpass = strip_tags($_POST['current_password']);
  $newpass = strip_tags($_POST['new_password']);
  $confirmpass = strip_tags($_POST['confirm_password']);
  if(strlen($currentpass)!=0 && strlen($newpass)!=0){
    if(strlen($newpass) >5){
      if($newpass == $confirmpass)
      {
        $auth_user->changePwd($currentpass,$newpass,$uid);
      }
      else
      {
        echo "<script type='text/javascript'>alert('Confirm password does not match.');</script>";
      }
    }
    else
    {
      echo "<script type='text/javascript'>alert('Password must be at least 6 charaters');</script>";
    }
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
<title>Reset Password</title>
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
          <form  method="post" action="resetpass.php">
              <div class="ID">
                <label id="usernameLabel">
                    New Password
                <label>
                <input id="newpass" type="pass" name="new_password" placeholder="New Password" required />
                <label id="usernameLabel">
                    Confirm Password
                <label>
                <input id="newpass" type="pass" name="confirm_password" placeholder="Confirm Password" required />
              </div>
              <div class="DONE">
                <input id="submitButton" value="Change Passowrd" type="submit" name="new_pass" class="button">
              </div>
          </form>
      </div><!--boxbody-->
    </div><!--box-->
</div><!--tm-container-->
</body>
</html>
