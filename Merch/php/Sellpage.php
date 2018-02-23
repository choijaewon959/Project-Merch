<?php
	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$user_id = $_SESSION['user_session'];
	$stmt->execute(array(":user_id"=>$user_id));
	$active_detail=$stmt->fetch(PDO::FETCH_ASSOC);

	$_SESSION['sellpage_error'] =NULL;



//______________________________________________________________________________________

	if(isset($_POST['btn_product_submit']))
	{
		try
		{
			$_SESSION['product_category'] = strip_tags($_POST['product_category']);

//Declare Session Variables
			$_SESSION['book_edition'] = $_SESSION['book_author'] =$_SESSION['book_subject'] = NULL;
			$_SESSION['clothe_brand'] =  $_SESSION['clothe_size_num'] = $_SESSION['clothe_size_char'] = NULL;
			$_SESSION['appliance_brand'] =NULL;
		}
		catch (PDOException $e)
		{
			$_SESSION['sellpage_error'] = $e;
		}
	}
//______________________________________________________________________________________
	if(isset($_POST['btn_clear']))
	{
		$_SESSION['product_title']= $_SESSION['product_category'] = $_SESSION['product_price'] =  $_SESSION['product_quality'] = $_SESSION['product_description'] = "";
	}
//______________________________________________________________________________________
	if(isset($_POST['btn_book_submit']))
	{
		try{
			$_SESSION['product_title'] = strip_tags($_POST['product_title']);
			$_SESSION['product_price'] = strip_tags($_POST['product_price']);
			$_SESSION['product_quality'] = strip_tags($_POST['product_quality']);
			$_SESSION['product_description'] = strip_tags($_POST['product_description']);

			$_SESSION['book_edition'] = strip_tags($_POST['book_edition']);
			$_SESSION['book_author'] = strip_tags($_POST['book_author']);
			$_SESSION['book_subject'] = strip_tags($_POST['book_subject']);
			$auth_user->addProduct($_SESSION['user_session'],$_SESSION['product_title'],$_SESSION['product_category'],$_SESSION['product_price'],$_SESSION['product_quality'],$_SESSION['product_description']);
			$auth_user->addBook($_SESSION['book_edition'] , $_SESSION['book_subject'],$_SESSION['book_author'],$_SESSION['product_id']);
		}
		catch(PDOException $e){
				$_SESSION['sellpage_error'] = $e;
				print_r($e);
		}
	}
//______________________________________________________________________________________

	else if(isset($_POST['btn_clothe_submit']))
	{
		try{
				$_SESSION['product_title'] = strip_tags($_POST['product_title']);
				$_SESSION['product_price'] = strip_tags($_POST['product_price']);
				$_SESSION['product_quality'] = strip_tags($_POST['product_quality']);
				$_SESSION['product_description'] = strip_tags($_POST['product_description']);

				$_SESSION['clothe_brand'] = strip_tags($_POST['clothe_brand']);
				$_SESSION['clothe_size_num'] = strip_tags($_POST['clothe_size_num']);
				$_SESSION['clothe_size_char'] = strip_tags($_POST['clothe_size_char']);

				$auth_user->addProduct($_SESSION['user_session'],$_SESSION['product_title'],$_SESSION['product_category'],$_SESSION['product_price'],$_SESSION['product_quality'],$_SESSION['product_description']);
				$auth_user->addClothe();
				}
		catch(PDOException $e	){
			$_SESSION['sellpage_error'] = $e;
			print_r($e);
		}
	}
//______________________________________________________________________________________

	else if(isset($_POST['btn_appliance_submit']))
	{
		try{
				$_SESSION['product_title'] = strip_tags($_POST['product_title']);
				$_SESSION['product_price'] = strip_tags($_POST['product_price']);
				$_SESSION['product_quality'] = strip_tags($_POST['product_quality']);
				$_SESSION['product_description'] = strip_tags($_POST['product_description']);

				$_SESSION['appliance_brand'] = strip_tags($_POST['appliance_brand']);

				$auth_user->addProduct($_SESSION['user_session'],$_SESSION['product_title'],$_SESSION['product_category'],$_SESSION['product_price'],$_SESSION['product_quality'],$_SESSION['product_description']);
				$auth_user->addAppliance();
				}
		catch(PDOException $e	){
			$_SESSION['sellpage_error'] = $e;
			print_r($e);
		}
	}
	//______________________________________________________________________________________



	$quality  = array("new","used","old");
	$category = array(" ","Book","clothe","appliance","etc");
	$size_char_array = array("XS","S","M","L","XL","XXL");

	//print_r($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sell_main</title>
	<link rel="stylesheet" type="text/css" href="../css/Sellpage_css.css">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="../js/Sellpage.js"></script>

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
					<li><a href="log_in.php">My shopping bag</a></li>
				</ul>
			</nav>


  </div><!--searchHeader-->
	<div class="input-container">
		<form action="Sellpage_test_180218.php" method="post" enctype="multipart/form-data">
			<div class="upload-Panel">
				<div class="title">
					<input type="text" id="titleTextBox" name= "product_title" placeholder="title" value =<?php if(isset($_SESSION['product_title'])){echo $_SESSION['product_title'];} ?> >
				</div>

				<div class="description">
					<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
				</div>
				<!--tester divs-->
				<div class="description">
					<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
				</div>	<div class="description">
						<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
					</div>	<div class="description">
							<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
						</div>	<div class="description">
								<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
							</div>	<div class="description">
									<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
								</div>	<div class="description">
										<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
									</div>	<div class="description">
											<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
										</div>	<div class="description">
												<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
											</div>	<div class="description">
													<textarea id="textareaTextBox" name="product_description" placeholder="description" value =<?php if(isset($_SESSION['product_description'])){print_r($_SESSION['product_description']);} ?> ></textarea>
												</div>

												<!--testerdivs-->

				<div class="price">
					<input id="priceTextBox" type="text" class="form-control" name="product_price" placeholder="price(HKD)" value =<?php if(isset($_SESSION['product_price'])){print_r($_SESSION['product_price']);} ?>>
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
					<input class="button" type="submit" name= "btn_product_submit"  value="Choose" >
					<input class="button" type="submit" name= "btn_clear"  value="Clear Detail" >
				</div>
		</form>
	</div><!--upload panel-->
	<div id="tips-panel">
		<header id="titleForTips">
			Tips for selling your items
		</header>
		<section id="contentForTips">
			<ul>
				<li>
					Upload Photo</br>
					<span id="detail">
						@Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
					</span>

				</li>
				<!--photo description-->

				<li>
					Add title and description</br>
					<span id="detail">
						@Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
					</span>
				</li>
				<!--title and description-->

				<li>
					Set price and quality of items</br>
					<span id="detail">
						@Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
					</span>
				</li>
				<!--price and quality-->

				<li>
					Hashtags</br>
					<span id="detail">
						@Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
					</span>
				</li>
				<!--hashtags-->

			</ul>
		</section>
	</div>

	</div><!-- input container -->
<!--_Book__________________________________________________________________________________-->
<?php
		if($_SESSION['product_category'] == "1")
		{
			?>
				 <form action="Sellpage_test_180218.php" method="post" enctype="multipart/form-data">
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
<?php	}
//_clothe_________________________________________________________________________________
		else if($_SESSION['product_category'] == "2")
		{

			?>
			<form action="Sellpage_test_180218.php" method="post" enctype="multipart/form-data">
			 	<div class="clothe_brand">
				 		<input id="textareaTextBox" name="clothe_brand" placeholder="brand" value =<?php if(isset($_SESSION['clothe_brand'])){echo $_SESSION['clothe_brand'];} ?> ></input>
			 	</div>
			 	<div class="size_char">
				 	Size in Char </br>
	<?php 		for($z =0 ; $z<sizeof($size_char_array); $z ++)
						{ 																																	?>
								<label ="new"> <?php echo $size_char_array[$z] ;?> </label>
								<input type="radio" name="clothe_size_char" value = <?php echo $z; ?> <?php if((int)$_SESSION['clothe_size_char'] == $z && isset($_SESSION['clothee_size_char'])){ echo 'checked';}?>>
	<?php			}																																		?>
			 </div>
			 <div class="size_num">
				 <input id="textareaTextBox" name="clothe_size_num" placeholder="clothe number size" value =<?php if(isset($_SESSION['clothe_size_num'])){echo $_SESSION['clothe_size_num'];} ?> ></input>
			 </div>
			 <input class="button" type="submit" name= "btn_clothe_submit"  value="Clothe Submit" >
			 </form>
<?php }
//_appliance_______________________________________________________________________________
		else if($_SESSION['product_category'] == "3")
		{
			?>
			<form action="Sellpage_test_180218.php" method="post" enctype="multipart/form-data">
				<div class="appliace_brand">
						<input id="textareaTextBox" name="appliance_brand" placeholder="appliance brand" value =<?php if(isset($_SESSION['appliance_brand'])){echo $_SESSION['appliance_brand'];} ?> ></input>
				</div>
				<input class="button" type="submit" name= "btn_appliance_submit"  value="appliance Submit" >
			</form>
<?php	}
?>


</body>
</html>
