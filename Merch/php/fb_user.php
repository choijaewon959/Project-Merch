<?php
  session_start();
  require_once("class.user.php");
  try
  {
    $merchuser = new USER();
    echo "<script type='text/javascript'>alert('Password must be at least 6 charaters');</script>";
    $stmt = $merchuser->runQuery("SELECT user_id FROM users WHERE email=:email AND fb=:id");
    $stmt->bindparam(":email",$_SESSION['fb_email']);
    $stmt->bindparam(":id", $_SESSION['fb_id']);
    $stmt->execute();

    if($userRow = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $_SESSION['user_session'] = $userRow['user_id'];
        $merchuser->redirect("https://wemerch.hk/php/Buypage.php");
    }
    else
    {
      $stmt = $merchuser->runQuery("INSERT INTO users(email,fb) VALUES(:email, :id)");
      $stmt->bindparam(":email",$_SESSION['fb_email']);
      $stmt->bindparam(":id", $_SESSION['fb_id']);
      $stmt->execute();
      $stmt = $merchuser->runQuery("SELECT user_id, email FROM users WHERE email=:email AND fb=:id");
      $stmt->bindparam(":email",$_SESSION['fb_email']);
      $stmt->bindparam(":id", $_SESSION['fb_id']);
      $stmt->execute();
      $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
      $_SESSION['user_session'] = $userRow['user_id'];
      $merchuser->redirect("https://wemerch.hk/php/Buypage.php");
    }
  }
  catch(PDOException $e)
  {
    print_r($e);
  }
?>
