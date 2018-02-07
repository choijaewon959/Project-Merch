<?php

	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();


	$user_name = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_name=:user_name");
	$stmt->execute(array(":user_name"=>$user_name));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

 // add errors
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <title>Sell Product! </title>
</head>
<body>
    <input type="text" class="form-control" name="txt_product_name" placeholder="Enter Product Name" value="<?php if(isset($error)){echo $uname;}?>" > </br>
    Quality </br>
    <form action="sellpage.php" method="post" enctype="multipart/form-data">
    <select name="quality">
      <option value="new" >New </option>
      <option value="used" >Used</option>
      <option value="etc" >Etc</option>
    </select>
    </br> category </br>
    <select name="category">
      <option value="book" >book </option>
      <option value="clothe" >clothe</option>
      <option value="appliance" >appliance</option>
      <option value="etc" >etc</option>
    </select>
  </form>

    <?php
          if(isset($_POST['category'])){
              $category = strip_tags($_POST['category']);
              if($category == "book"){
                $edition = strip_tags($_POST['txt_edition']);
                $author = strip_tags($_POST['txt_author']);
                $subject = strip_tags($_POST['txt_subject']);
    ?>
              <form action="sellpage.php" method="post" enctype="multipart/form-data">
                <input type="text" class="form-control" name="txt_edition" placeholder="Enter Book Edition" value="<?php if(isset($error)){echo $uname;}?>" >
                <input type="text" class="form-control" name="txt_author" placeholder="Enter Author" value="<?php if(isset($error)){echo $uname;}?>" >
                <input type="text" class="form-control" name="txt_subject" placeholder="Enter Subject or Course Code" value="<?php if(isset($error)){echo $uname;}?>" >
             </form>
    <?php     }
              else if($category == "clothe"){
                $brand = strip_tags($_POST['txt_brand']);
                $txt_size = strip_tags($_POST['txt_size']);
                $int_size = strip_tags($_POST['int_size']);
    ?>
              <form action="sellpage.php" method="post" enctype="multipart/form-data">
                <input type="text" class="form-control" name="txt_brand" placeholder="Enter Brand" value="<?php if(isset($error)){echo $uname;}?>" >
                <input type="text" class="form-control" name="txt_size" placeholder="Enter size in terms of S,M,L,XL,XXL" value="<?php if(isset($error)){echo $uname;}?>" >
                <input type="text" class="form-control" name="int_size" placeholder="Enter size in terms of number" value="<?php if(isset($error)){echo $uname;}?>" >
              </form >
    <?php        }
              else if($category == "appliance"){ ?>
                <form action="sellpage.php" method="post" enctype="multipart/form-data">
                <input type="text" class="form-control" name="txt_brand" placeholder="Enter Book Edition" value="<?php if(isset($error)){echo $uname;}?>" >
                <input type="text" class="form-control" name="txt_size" placeholder="Enter Author" value="<?php if(isset($error)){echo $uname;}?>" >
                <input type="text" class="form-control" name="int_size" placeholder="Enter Subject or Course Code" value="<?php if(isset($error)){echo $uname;}?>" >
                </form>
    <?php          }
          }
    ?>
    </br>
    <input type="integer" class="form-control" name="price" placeholder="Enter Price" value="<?php if(isset($error)){echo $uname;}?>" >
    </br>
    <input value="Submit" type="submit" class="button" name="btn-signup">
  </div>

  </body>
  </html>
