<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contact Us</title>
<link rel="stylesheet" href="style1.css" type="text/css"  />
</head>
<body>

<div id="main2">



<?php

$a = $_POST['a'];
          $b = $_POST['b'];
          $ans = $_POST['ans'];
          $spam = $a + $b;
if($ans == $spam)
{

$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$message = $_POST['message'];


$to = "naeemcomputertraining@gmail.com, $email";
$subject = $name."\x10 ";
$headers = "From: Naeem Hussain <naeem@example.com>";
$email_message = '

Dear '.$name.'
Thank you very much to contact us. You contact inforamtion below


   Name   : '.$name.'
   Email  : '.$email.'
   Mobile :'.$mobile.'
   Message:'.$message.'

';



 mail($to,$subject,$email_message, $headers);

 echo '<p><font color="green"><strong> Message has beeen seen successfully. </strong> </font></p>';

}


else{


          die('<p><font color="red"><strong> Wrong Answer! <br/> Please calculate the number again and try  to give correct answer. </strong> </font></p>' );



    }



?>


</div>
</body>
</html>
