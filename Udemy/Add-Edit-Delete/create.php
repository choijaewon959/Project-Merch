
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Access Denied</title>
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>



	<div id="main2">

								<h1><font color='red'>Opps! Something went wrong</font></h1>

<?php
require_once 'dbconfig.php';



						 $a = $_POST['a'];
						 $b = $_POST['b'];
					   $ans = $_POST['ans'];
						 $spam = $a + $b;
if($ans == $spam)
{

	$email = $_POST['email'];
	$stmt=$db_con->prepare("SELECT * FROM member WHERE email=:em");
	$stmt->execute(array(':em'=>$email));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);



	if($row>0) {

  die( '<p>Sorry! Member Already Exists</p>');


   }



	if($_POST)
	{
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$cdate = $_POST['cdate'];
		$city = $_POST['city'];




		try{

			$stmt = $db_con->prepare("INSERT INTO
		  member(name,  gender, email,  cdate, city)
			VALUES(:ename,  :gender, :email, :cdate, :city)");
			$stmt->bindParam(":ename", $name);
			$stmt->bindParam(":gender", $gender);
			$stmt->bindParam(":email", $email);
			$stmt->bindParam(":cdate", $cdate);
			$stmt->bindParam(":city", $city);



			if($stmt->execute())
			{
				echo "Successfully Added";
			}
			else{
				echo "Query Problem";
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}


		header("Location: index.php");


?>









               <p><b><?php   }else{


							 				echo '<p> Wrong Answer! <br/> Please calculate the number again and try  to give correct answer. </p>';



							 	} ?></b></p>


								<p><a href="home.php" ><button class="button" >Back</button</a>
</p>
        </div>







</body>
</html>
