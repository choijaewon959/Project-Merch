<?php
require_once 'dbconfig.php';


	if($_POST)
	{
		$id = $_POST['id'];
		$name = $_POST['name'];

		$gender = $_POST['gender'];
		$email =  $_POST['email'];

		$cdate = $_POST['cdate'];
		$city = $_POST['city'];


		$stmt = $db_con->prepare("UPDATE member SET name=:en,
			 gender=:gd, email=:em,  cdate=:cd, city=:ct
 WHERE id=:idr");
		$stmt->bindParam(":en", $name);

		$stmt->bindParam(":gd", $gender);
		$stmt->bindParam(":em", $email);

		$stmt->bindParam(":cd", $cdate);
		$stmt->bindParam(":ct", $city);
		$stmt->bindParam(":idr", $id);

		if($stmt->execute())
		{
		// any success message
		}
		else{
			echo "Query Problem";
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Access Denied</title>
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>



	<div id="main2">

								<h1><font color='green'>Congratulation!</font></h1>

               <p><b>Member Updated in Database.</b></p>


								<p><a href="index.php" ><button class="button" >Back</button</a>
</p>
        </div>







</body>
</html>
