<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require '/home/bitnami/vendor/autoload.php';
  session_start();
  require_once("class.user.php");
  $login = new USER();
  $umail = $_SESSION['umail'];
  echo "<script type='text/javascript'>alert('".$umail."');</script>";
  if($login->checkEmail($umail))
  {
    $str = "1234567890!@#$%^&*";
    $str = str_shuffle($str);
    $str = substr($str, 0, 10);
    $stmt = $login->runQuery("UPDATE users SET token=:token WHERE email=:email");
    $stmt->bindparam(":token", $str);
    $stmt->bindparam(":email", $umail);
    $stmt->execute();
    $url = "wemerch.hk/php/resetpass.php?token=$str&email=$umail";
    require '../PHPMailer-master/PHPMailerAutoload.php';
    $mail = new PHPMailer();
    $mail ->IsSmtp();
    $mail ->SMTPDebug = 0;
    $mail ->SMTPAuth = true;
    $mail ->SMTPSecure = 'ssl';
    $mail ->Host = "smtp.gmail.com";
    $mail ->Port = 465; // or 465
    $mail ->IsHTML(true);
    $mail ->Username = "wemerch.hk@gmail.com";
    $mail ->Password = "thereisnochallenge";
    $mail ->SetFrom("wemerch.hk@gmail.com");
    $mail ->Subject = "Merch - Reset Password URL";
    $mail ->Body = $url;
    $mail ->AddAddress($umail);
    if(!$mail->Send())
    {
      echo "<script type='text/javascript'>alert('".$mail->ErrorInfo."');</script>";
    }
    else
    {
      echo "<script type='text/javascript'>alert('sent.');</script>";
    }
  }
  else
  {
    $display = "<b>User Email does not exist !</b>";
  }
?>
