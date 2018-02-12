
<?php
include_once 'dbconfig.php';

if($_GET['eid'])
{
	$id = $_GET['eid'];
	$stmt=$db_con->prepare("SELECT * FROM member WHERE id=:id");
	$stmt->execute(array(':id'=>$id));
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Insert, Update, Delete using jQuery, PHP and MySQL</title>
<link href="style.css" rel="stylesheet" type="text/css">



</head>

<body>



    <div id="main2">




	 <form method='post' action="update.php">

    <table class='table table-bordered'>


<tr>
	    <td colspan="2"><h1>Edit Information </h1></td>
</tr>

 		<input type='hidden' name='id' value="<?php echo $row['id']; ?>" />
		<tr>
				<td>Name</td>
				<td><input type='text' name='name' value="<?php echo $row['name']; ?>" class='form-control' placeholder='' /></td>
		</tr>



		<tr>
				<td>Date</td>
				<td><input type='text' name='cdate' value="<?php echo $row['cdate']; ?>"  class='form-control' placeholder='' ></td>
		</tr>

		<tr>
				<td>Gender: </td>
				<td> <div class="selector"> <select name="gender" >
<option value="<?php echo $row['gender']; ?>"><?php echo $row['gender']; ?></option>
<option value="Male">Male</option>
<option  value="Female">Female</option>
</select>

</div>
</td>
		<tr>
				<td>Email</td>
				<td><input type='text' name='email'  value="<?php echo $row['email']; ?>"  class='form-control' placeholder='' ></td>
		</tr>
		<tr>
				<td>City</td>
				<td><input type='text' name='city'  value="<?php echo $row['city']; ?>" class='form-control' placeholder=''></td>
		</tr>

        <tr>

            <td></td><td>
            <button type="submit" class="button" >Save Updates
			</button>

            </td>
        </tr>

    </table>
</form>
</div>
</body>
</html>
