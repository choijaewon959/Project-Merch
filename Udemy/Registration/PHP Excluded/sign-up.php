
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PDO : Sign up</title>
<link rel="stylesheet" href="style.css" type="text/css"  />
</head>
<body>

<div id="main">



            <input type="text" class="form-control" name="txt_uname" placeholder="Enter Username" value="<?php if(isset($error)){echo $uname;}?>" />


            <input type="text" class="form-control" name="txt_umail" placeholder="Enter E-Mail ID" value="<?php if(isset($error)){echo $umail;}?>" />


            	<input type="password" class="form-control" name="txt_upass" placeholder="Enter Password" />


            	<input value="SIGN UP" type="submit" class="button" name="btn-signup">


            <p>have an account ! <a href="index.php">Sign In</a></p>
        </form>


</div>

</body>
</html>
