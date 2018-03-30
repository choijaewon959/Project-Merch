<?php
	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$user_id = $_SESSION['user_session'];
	$stmt->execute(array(":user_id"=>$user_id));
	$active_detail=$stmt->fetch(PDO::FETCH_ASSOC);

	$quality  = array("new","used","old");
	$category = array(" ","Book","clothe","appliance","etc");
	$size_char_array = array("XS","S","M","L","XL","XXL");
	//print_r($_SESSION);
	$hash_arr = array();

	if(!isset($_SESSION['product_category']))
	{
		$_SESSION['product_category'] = $_SESSION['product_title'] = $_SESSION['product_price'] = $_SESSION['product_quality'] = $_SESSION['product_description'] = $_SESSION['product_hashtag'] = "";
		unset($_SESSION['product_id']);
	}
	$_SESSION['sellpage_error'] =NULL;
//______________________________________________________________________________________

	if(isset($_POST['btn_product_submit']))
	{
		try
		{
			$_SESSION['product_category'] = strip_tags($_POST['product_category']);
			$_SESSION['product_title'] = strip_tags($_POST['product_title']);
			$_SESSION['product_price'] = strip_tags($_POST['product_price']);
			$_SESSION['product_quality'] = strip_tags($_POST['product_quality']);
			$_SESSION['product_description'] = strip_tags($_REQUEST['product_description']);
			$_SESSION['product_hashtag'] = strip_tags($_REQUEST['product_hashtag']);

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
// clear button
	if(isset($_POST['btn_clear']))
	{
		$_SESSION['product_title']= $_SESSION['product_category'] = $_SESSION['product_price'] =  $_SESSION['product_quality'] = $_SESSION['product_description'] = "";
	}

	if(isset($_POST['btn_book_submit']))
	{
		try{
			$_SESSION['book_edition'] = strip_tags($_POST['book_edition']);
			$_SESSION['book_author'] = strip_tags($_POST['book_author']);
			$_SESSION['book_subject'] = strip_tags($_POST['book_subject']);
			$hash_arr = $auth_user->convert_hashtag();
			$auth_user->addProduct();
			$auth_user->addBook();
			$auth_user->addHashtag($hash_arr);

		}
		catch(PDOException $e){
				$_SESSION['sellpage_error'] = $e;
				//print_r($e);
		}
	}

	else if(isset($_POST['btn_clothe_submit']))
	{
		try{

				$_SESSION['clothe_size_num'] = strip_tags($_POST['clothe_size_num']);
				$_SESSION['clothe_size_char'] = strip_tags($_POST['clothe_size_char']);

				$auth_user->addProduct();
				$auth_user->addClothe();
				$auth_user->addHashtag($hash_arr);

				}
		catch(PDOException $e	){
			$_SESSION['sellpage_error'] = $e;
			//print_r($e);
		}
	}

	else if(isset($_POST['btn_appliance_submit']))
	{
		try{
				$_SESSION['appliance_brand'] = strip_tags($_POST['appliance_brand']);

				$auth_user->addProduct();
				$auth_user->addAppliance();
				$auth_user->addHashtag($hash_arr);

				}
		catch(PDOException $e	){
			$_SESSION['sellpage_error'] = $e;
			//print_r($e);
		}
	}
//Below is file i/o________________________________________________________________________________
	$_SESSION['uploaded'] = 0;
		for($a = 0; $a < sizeof($_FILES["product_image"]["name"]); $a ++)
		{
			if($_FILES["product_image"]["error"][$a] == 0)
			{
					$file_dir = "uploads/";
					$image_file = $file_dir . basename($_FILES["product_image"]["name"][$a]);
					$imageFileType = strtolower(pathinfo($image_file,PATHINFO_EXTENSION));
					$allowed = array("image/jpg" => "jpg", "image/jpeg" => "jpeg", "image/gif" => "gif", "image/png" => "png");
					$product__id = $_SESSION['product_id'];
					$product__id = $product__id +1;
					$image_type = $_FILES["product_image"]["type"][$a];
					// image name is set as seller_id + product id + photo sequence number
					$image_name = (string)$_SESSION['user_session']."_".(string)$product__id."_".(string)$a.'.'.$allowed[$image_type];
					$name_tmp = (string)$_SESSION['user_session']."_".(string)$product__id."_".(string)$a;
					$image_size = $_FILES["product_image"]["size"][$a];
				  $check = getimagesize($_FILES["product_image"]["tmp_name"][$a]);

			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
							unset($_SESSION['uploaded']);
			        $_SESSION['uploaded'] = 1;
			    } else {
			        echo "File is not an image.";
							unset($_SESSION['uploaded']);
			        $_SESSION['uploaded'] = 0;
			    }

			if (file_exists($image_file)) {
			    echo "Sorry, file already exists.";
					unset($_SESSION['uploaded']);
					$_SESSION['uploaded'] = 0;
			}
			if ($image_size > 500000) {
			    echo "Sorry, your file is too large.";
					unset($_SESSION['uploaded']);
					$_SESSION['uploaded'] = 0;
			}
		  if(!array_key_exists($image_type, $allowed))
			{
					echo "Error: Please select a valid file format.";
			}
			foreach($allowed as $b => $c)
			{
				$dir = "..\\Database\\image\\".$name_tmp.'.'.$c;
				echo $dir;
				if(file_exists($dir))
				{
					unlink($dir);
				}
			}
			// Check if $_SESSION['uploaded'] is set to 0 by an error
			if ($_SESSION['uploaded'] == 0) {
			    echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["product_image"]["tmp_name"][$a], "C:\\xampp\\htdocs\\Merch\\Database\\image\\".$image_name)) {
			        echo "The file ". basename( $_FILES["product_image"]["name"][$a]). " has been uploaded.";
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
				}
		}
	}
}
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
					<li><button onclick="document.getElementById('requestModal').style.display='block'">Request</button></li>
					<li><a href="Buypage_loggedin.php">Buy</a></li>
					<li><a href="mypage.php">My page</a></li>
					<li><a href="log_in.php">My shopping bag</a></li>
				</ul>
			</nav>


  </div><!--searchHeader-->

	<div id="requestModal">
		<div id="requestContentDiv">
			request
			<button type="button" onclick="document.getElementById('requestModal').style.display='none'">Close</button>
		</div>
	</div><!--requestModal-->

	<button onclick="openNav()">click</button>
	<div class="requestedPanel" id="requested">
			<!-- Button to close the overlay navigation -->
	  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

	  <!-- Overlay content -->
	  <div class="overlay-content">
	    fuckyou
	  </div>
	</div>


	<div class="input-container">
		<form action="Sellpage.php" method="post" enctype="multipart/form-data">
			<div class="upload-Panel">
				<h1 id="heading">
					<label id="detailLabel">Details</label></br>
					<p id="contentForDetail">
						@Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</h1>
				<div class = "category">
						<label id="categoryLabel">Category</label></br>
						<select id="categorySelectBar" name="product_category">
<?php					for ($y = 0; $y < sizeof($category) ; $y++)
 							{?>
										<option value=<?php echo $y; ?>
										 																	<?php if((int)$_SESSION['product_category'] == $y){ echo "selected";} ?> > <?php echo $category[$y]; ?>  </option>
<?php					}																																						 	?>
				  	</select>
						<input class="button" type="submit" name= "btn_product_submit"  value="Choose" action ="sellpage.php" >
				</div>
				<div class="title">
					<label id="titleLabel">Title</label></br>
					<input type="text" id="titleTextBox" name= "product_title" value =<?php if(isset($_SESSION['product_title'])){echo $_SESSION['product_title'];} ?> >
				</div>


				<div class="photo">
					<label id="photoLabel">Photo</label></br>
					<p id="recommend">Recommended - photograph always gives a much better response<p></br>

					<label for="product_image" class="custom-file-upload">
						Add a photo
					</label>
					<form id="photoUploadPanel" action="sellpage.php" method="post" enctype="multipart/form-data">
						<input type="file" name="product_image[]" id="product_image" multiple= "multiple">
						<!--<input type="submit" value="Upload" name="image_submit">-->
					</form>
					<p id="addupto">You can add up to 3 images</p>
				</div>


				<div class="description">
					<label id="descriptionLabel">Description</label></br>
					<textarea id="textareaTextBox" name="product_description" placeholder="Add Description to your product! "><?php if(isset($_SESSION['product_description'])){echo $_SESSION['product_description'];} ?></textarea>
				</div>

				<div class="price">
					<label id="priceLabel">Price</label></br>
					<input id="priceTextBox" type="text" class="form-control" name="product_price" placeholder="price(HKD)" value =<?php if(isset($_SESSION['product_price'])){print_r($_SESSION['product_price']);} ?>>
				</div>

				<div class="quality">
						<label id="qualityLabel">Quality</label></br>
						<div id="radios">
<?php					for ($x = 0; $x < sizeof($quality); $x++) {										?>
								<label ="new"> <?php echo $quality[$x] ;?> </label>
								<input type="radio" name="product_quality" value = <?php echo $x; ?> <?php if((int)$_SESSION['product_quality'] == $x){ echo 'checked';}?>>
  						  <span class="checkmark"></span>
<?php 					}
																												 	?>
						</div>
				</div>

			<!--Receive hashtags -->
			<div class="hashtag">
				<label id="hashtagLabel">Hashtag</label></br>
				<textarea id="hashtagTextArea" name="product_hashtag" placeholder="Add Hashtags to your product!"><?php if(isset($_SESSION['product_hashtag'])){echo $_SESSION['product_hashtag'];} ?></textarea>
			</div>

				<input class="button" type="submit" name= "btn_clear"  value="Clear Detail" action ="sellpage.php" >

			</br>
		</form>
<!--Upload Image file -->

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
				 <form action="Sellpage.php" method="post" enctype="multipart/form-data">
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
			<form action="Sellpage.php" method="post" enctype="multipart/form-data">
			 	<div class="size_char">
				 	<label name=size_char> Size in Char </br> </label>
	<?php 		for($z =0 ; $z<sizeof($size_char_array); $z ++)
						{ 																																	?>
								<label ="new"> <?php echo $size_char_array[$z] ;?> </label>
								<input type="radio" name="clothe_size_char" value = <?php echo $z; ?> <?php if((int)$_SESSION['clothe_size_char'] == $z && isset($_SESSION['clothe_size_char'])){ echo 'checked';}?>>
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
			<form action="Sellpage.php" method="post" enctype="multipart/form-data">
				<div class="appliace_brand">
						<input id="textareaTextBox" name="appliance_brand" placeholder="appliance brand" value =<?php if(isset($_SESSION['appliance_brand'])){echo $_SESSION['appliance_brand'];} ?> ></input>
				</div>
				<input class="button" type="submit" name= "btn_appliance_submit"  value="appliance Submit" >
			</form>
<?php	}
?>


</body>
</html>
