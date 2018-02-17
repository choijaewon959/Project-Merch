<?php

	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$price ="";
	$category = "";
	$editionerr = $authorerr = "";
	$edition = $author = "";

	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sell_main</title>
	<link rel="stylesheet" type="text/css" href="../css/Sellpage_css.css">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
</head>
<body>
	<div class="searchHeader">
		<div class="Logo">
			<div id="merchText">
				<a href="Buypage_loggedin.php">Merch</a>
			</div>
		</div>

		<div class="tm-container">
			<form action="search.php" method="post">
        <span>
					<button class="searchButton"></button>
				</span>
				<span class="searchBar">
					<input id="searchbar" type="text" name="hashTag" placeholder="#COMP2123 #ComputerScience #Kit #..">
				</span>
			</form>
		</div>


		<nav class="tm-nav">
				<ul>
					<li><a href="log_in.php">Request</a></li>
					<li><a href="log_in.php">Sell</a></li>
					<li><a href="sign_in.php">Sign up</a></li>
					<li><a href="log_in.php">Log in</a></li>
				</ul>
			</nav>

		</br></br></br>
				<span class="price">
					<span id="priceText">Price</span>
					<input id="price" type="text" class="form-control" name="price" placeholder="price" value ="<?php if(isset($error)){$price;} ?>"/>
				</span>
		</nav>
  </div><!--searchHeader-->
  </div>
  </div><!--filterDiv-->
	<div class="input-container">
		<div class="title">
			<input type="text" id="titleTextBox" placeholder="title">
		</div>

		<div class="description">
			<textarea id="textareaTextBox" placeholder="description"></textarea>
		</div>
		<div class="price">
			<input id="priceTextBox" type="text" class="form-control" name="price" placeholder="price(HKD)" value ="<?php if(isset($price)){$price;} ?>"/>
		</div>
		<div class="quality">
				<span id="rateText">Quality:</span>
				<span id="radios">
					<label for="new">new</label>
					<input type="radio" name="quality" value="new">
					<label for="used">used</label>
					<input type="radio" name="quality" value="used">
					<label for="used">old</label>
					<input type="radio" name="quality" value="old">
				</span>
		</div>

				<form action="" method="post" enctype="multipart/form-data">
						Category
						<select name="category" >
							<option value="" >  </option>
					    <option value="book" >Book </option>
					    <option value="clothe" >Clothe</option>
					    <option value="appliance" >Appliance</option>
					    <option value="etc" >Etc</option>
					  </select>
					<input class="button" type="submit"  value="Choose" >
				</form>
	</div><!-- input container -->
		<?php
			if(isset($_POST['category']))
			{
				try
				{
					$category = strip_tags($_POST['category']);
					$price = strip_tags($_POST['price']);
				}
				catch (PDOException $e)
				{
					if( $e->getline()==80){echo "Enter Category";}
					else if($e -> getline() ==81){echo "Enter Price";}
				}
				$category = strip_tags($_POST['category']);
				$price = strip_tags($_POST['price']);
				$category = $_POST['category'];
				if($category == "book"){
					echo '<form action="" method="post" enctype="multipart/form-data">';
					echo '<p><input type="text" id="edition" name="edition"/ placeholder = "Edition"/></br></p>';
					echo '<p><input type="text" id="author" name="author" placeholder = "Author" </br></p>';
					echo '<input class="button" type="submit"  value="submit" name = "btn-submit" >';
						if(isset($_POST['btn-submit']))
						{
							echo "plz";
							$edition = strip_tags($_POST['edition']);
							$author = strip_tags($_POST['author']);
							if($edition==""){
								$error[] = "<b><font color='red'>provide edition !</font></b>";
							}
							else if($author==""){
								$error[] = "<b><font color='red'>provide author !";
							}
							else if($price==""){
								$error[] = "<b><font color='red'>provide price !";
							}
							else if($category==""){
								$error[] = "<b><font color='red'>provide category !";
							}
							else {
									try{
										$stmt = $this->$conn->prepare("INSERT into sell_product(seller_id,quality,category,price)
																							VALUES(:seller_id,:quality,:category,:price)");
										$stmt->bindparam(":price",$price);
										$stmt->bindparam(":seller_id",$user_id);
										$stmt->bindparam(":quality",$quality);
										$stmt->bindparam(":category",$category);
										$stmt->excute();
										$stmt = $this->$conn->prepare("INSERT into book(edtion,author)
																							VALUES(:edition,:author)");
										$stmt->bindparam(":edition",$edition);
										$stmt->bindparam(":author",$author);
										$stmt->excute();
										return $stmt;
									}
									catch(PDOException $e)
									{
										echo $e->getMessage();
									}
								}
						}
					}
			if(isset($error))
			{
				foreach($error as $error)
				{
					 ?>
										 <div class="alert alert-danger">
												<i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?>
										 </div>
										 <?php
				}
			}
			else if(isset($_GET['joined']))
			{
				 ?>
								 <div class="alert alert-info">
											<i class="glyphicon glyphicon-log-in"></i> &nbsp; Product Successfully registered
								 </div>
								 <?php
			}
		}
		?>

</body>
</html>
