

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Access Denied</title>
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>
<?php
	include_once 'dbconfig.php';

	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$stmt=$db_con->prepare("DELETE FROM member WHERE id=:id");
		$stmt->execute(array(':id'=>$id));
	}
?>
	<div id="main2">

								<h1><font color='red'>Member Deleted !</font></h1>

               <p><b>Member Deleted permenatly from record.</b></p>


								<p><a href="index.php" ><button class="button" >Back</button</a>
</p>
        </div>







</body>
</html>
