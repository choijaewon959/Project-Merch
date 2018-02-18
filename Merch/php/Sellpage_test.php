<?php
	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$active_detail=$stmt->fetch(PDO::FETCH_ASSOC);

	$_SESSION['product_title'] = $_SESSION['product_category'] = $_SESSION['product_price'] = $_SESSION['product_quality'] = $_SESSION['product_description'] = NULL;
	$_SESSION['book_edition'] = $_SESSION['book_author'] =$_SESSION['book_subject'] = NULL;
	$_SESSION['clothe_brand'] =  $_SESSION['clothe_size_num'] = $_SESSION['clothe_size_char'] = NULL;
	if(isset($_POST['btn-submit']))
	{
		try
		{
			$_SESSION['product_title'] = strip_tags($_POST['product_title']);
			$_SESSION['product_category'] = strip_tags($_POST['product_category']);
			$_SESSION['product_price'] = strip_tags($_POST['product_price']);
			$_SESSION['product_quality'] = strip_tags($_POST['product_quality']);
			$_SESSION['product_description'] = strip_tags($_POST['product_description']);
		}
		catch (PDOException $e)
		{

		}
	}
	if(isset($_POST['btn-clear']))
	{
		$_SESSION['product_title']= $_SESSION['product_category'] = $_SESSION['product_price'] =  $_SESSION['product_quality'] = $_SESSION['product_description'] = "";
	}
	if(isset($_POST['btn_book_submit']))
	{
		try{
			$_SESSION['book_edition'] = strip_tags($_POST['book_edition']);
			$_SESSION['book_author'] = strip_tags($_POST['book_author']);
			$_SESSION['book_subject'] = strip_tags($_POST['book_subject']);
		}
		catch(PDOException $e){}
	}
	if(isset($_POST['btn_clothe_submit']))
	{
		try{
				$_SESSION['clothe_brand'] = strip_tags($_POST['clothe_brand']);
				$_SESSION['clothe_size_num'] = strip_tags($_POST['clothe_size_num']);
				$_SESSION['clothe_size_char'] = strip_tags($_POST['clothe_size_char']);
				}
		catch(PDOException $e	){}
	}
	$quality  = array("new","used","old");
	$category = array(" ","Book","clothe","appliance","etc");
	$size_char_array = array("XS","S","M","L","XL","XXL");

	print_r($_SESSION);
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
					<li><a href="">Request</a></li>
					<li><a href="Buypage_loggedin.php">Buy</a></li>
					<li><a href="mypage.php">My page</a></li>
					<li><a href="log_in.php">My cart</a></li>
				</ul>
			</nav>

		</br></br></br>
				<span class="price">
					<span id="priceText">Price</span>
					<input id="price" type="text" class="form-control" name="search_price" placeholder="price"/>
				</span>
		</nav>
  </div><!--searchHeader-->
	<div class="input-container">
		<form action="Sellpage_test.php" method="post" enctype="multipart/form-data">

				<div class="title">
					<input type="text" id="titleTextBox" name= "product_title" placeholder="title" value =<?php if(isset($_SESSION['product_title'])){echo $_SESSION['product_title'];} ?> >
				</div>

				<div class="description">
					<input id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){echo $_SESSION['product_description'];} ?> ></input>
				</div>

				<div class="price">
					<input id="priceTextBox" type="text" class="form-control" name="product_price" placeholder="price(HKD)" value =<?php if(isset($_SESSION['product_price'])){echo $_SESSION['product_price'];} ?>>
				</div>

				<div class="quality">
						<span id="rateText">Quality:</span>
						<span id="radios">
<?php					for ($x = 0; $x < sizeof($quality); $x++) {										?>
								<label ="new"> <?php echo $quality[$x] ;?> </label>
								<input type="radio" name="product_quality" value = <?php echo $x; ?> <?php if((int)$_SESSION['product_quality'] == $x){ echo 'checked';}?>>
<?php 					}
																												 	?>
						</span>
				</div>
				<div class = "category">
					<span id="rateText">Category:</span>
						<select name="product_category">
<?php					for ($y = 0; $y < sizeof($category) ; $y++)
 							{?>
										<option value=<?php echo $y; ?>
										 																	<?php if((int)$_SESSION['product_category'] == $y){ echo "selected";} ?> > <?php echo $category[$y]; ?>  </option>
<?php					}																																						 	?>
				  	</select>
					<input class="button" type="submit" name= "btn-submit"  value="Choose" >
					<input class="button" type="submit" name= "btn-clear"  value="Clear Detail" >
				</div>
		</form>
	</div><!-- input container -->
<?php
		if((int)$_SESSION['product_category'] == 1) // book
		{ ?>
				 <form action="Sellpage_test.php" method="post" enctype="multipart/form-data">
				 <div class="edition">
				 	<input id="textareaTextBox" name="book_edition" placeholder="edition" value =<?php if(isset($_SESSION['book_edition'])){echo $_SESSION['book_edition'];} ?> ></input>
				 </div>
				 <div class="author">
				<input id="textareaTextBox" name="book_author" placeholder="author" value =<?php if(isset($_SESSION['book_author'])){echo $_SESSION['book_author'];} ?> ></input>
				 </div>
				 <div class="subject">
					<input id="textareaTextBox" name="book_subject" placeholder="subject" value =<?php if(isset($_SESSION['book_subject'])){echo $_SESSION['book_subject'];} ?> ></input>
				 </div>
				 <input class="button" type="submit" name= "btn_book_submit"  value="Book Submit" >
				 </form>
<?php		}
		else if((int)$_SESSION['product_category'] == 2)  //clothe
		{
		?>
		<form action="Sellpage_test.php" method="post" enctype="multipart/form-data">
		 	<div class="brand">
			 		<input id="textareaTextBox" name="clothe_brand" placeholder="brand" value =<?php if(isset($_SESSION['product_description'])){echo $_SESSION['product_description'];} ?> ></input>
		 	</div>
		 	<div class="size_char">
			 	Size in Char </br>
<?php 		for($z =0 ; $z<sizeof($size_char_array); $z ++)
					{ 																																	?>
							<label ="new"> <?php echo $size_char_array[$z] ;?> </label>
							<input type="radio" name="clothe_size_char" value = <?php echo $z; ?> <?php if((int)$_SESSION['clothe_size_char'] == $z && isset($_SESSION['clothe_size_char'])){ echo 'checked';}?>>
<?php			}																																		?>
		 </div>
		 <div class="size_num">
			 <input id="textareaTextBox" name="clothe_size_num" placeholder="clothe number size" value =<?php if(isset($_SESSION['product_description'])){echo $_SESSION['product_description'];} ?> ></input>
		 </div>
		 <input class="button" type="submit" name= "btn_clothe_submit"  value="Clothe Submit" >
		 </form>
<?php}
		else if((int)$_SESSION['product_category'] == 3) //appliance
		{ ?>

<?php		}  ?>

</body>
</html>
