<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add New Member</title>
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

	<div id="main2">
	 <form method='post'  action="create.php">

    <table class='table table-bordered'>

		<tr>
				<td colspan="2">	<h1> New Member Registration</h1></td>
		</tr>

        <tr>
            <td>Name</td>
            <td><input type='text' name='name'  placeholder='' required /></td>
        </tr>

  <input type='hidden' name='cdate'  value="<?php echo date('Y-m-d'); ?>" class='form-control' placeholder='' >


				<tr>
						<td>Gender</td>
						<td><select name="gender" class='form-control'>
	 <option value="Male">Male</option>
	 <option  value="Female">Female</option>
</select></td>
				<tr>
						<td>Email</td>
						<td><input type='text' name='email' placeholder='Add email' ></td>
				</tr>
				<tr>
						<td>City</td>
						<td><input type='text' name='city' class='form-control' placeholder='Add City'>
				</tr>

				<tr>
						<td>Question:

				    <?php

				                                   $a = rand(0, 9);
				                                   $b = rand(0, 9);

				                                 ?> &nbsp;<span class="red"><?php echo "$a + $b"; ?> =</span><br>
				                                  <input value="<?php echo $a ?>"  name="a" type="hidden">
				                                 <input value=" <?php echo $b ?>" name="b"  type="hidden"></td>

																				  <td> <input type="text"  placeholder='answer here' name="ans" /></td>

				</tr>

        <tr>
				<td></td>
				<td ><input class="check"  type="checkbox" checked="checked" ><a href="" target="_blank">I Agree</a>
								</td>
				</tr>
				<tr>
          <td></td><td>
			  <button type="submit" class="button" >
    	 Register
			</button>
            </td>
        </tr>

    </table>
</form>

</div>

</div>
</body>
</html>
