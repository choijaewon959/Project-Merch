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
	$hash_arr = array();
	if(!isset($_SESSION['product_category']))
	{
		$_SESSION['product_title']= $_SESSION['product_category']  = $_SESSION['product_price'] = $_SESSION['product_quality'] = $_SESSION['product_description'] = $_SESSION['product_hashtag'] = "";
		unset($_SESSION['product_id']);
	}
	$auth_user->productId();
	$_SESSION['sellpage_error'] =NULL;

//______________________________________________________________________________________
$_SESSION['uploaded'] = 0 ;
$counter = 0 ;
$error_displayed = false;
	if(isset($_POST['btn_product_submit']))
	{
		try
		{
			$_SESSION['product_title'] = strip_tags($_POST['product_title']);
			$_SESSION['product_category'] = strip_tags($_POST['product_category']);
			$_SESSION['product_price'] = strip_tags($_POST['product_price']);
			$_SESSION['product_quality'] = strip_tags($_POST['product_quality']);
			$_SESSION['product_description'] = strip_tags($_REQUEST['product_description']);
			$_SESSION['product_hashtag'] = strip_tags($_REQUEST['product_hashtag']);
			$_SESSION['uploaded'] = 0;
			$len = sizeof($_FILES["files"]["name"]);
			$names = array();
			if (strlen($_SESSION['product_title']) > 20)
			{
				echo "<script type='text/javascript'>alert('Maximum title length is 20 characters.');</script>";
			}
			else if($_SESSION['product_category'] == 0)
			{
				echo "<script type='text/javascript'>alert('Category must be chosen.');</script>";
			}
			else if(strlen($_SESSION['product_description']) > 100)
			{
				echo "<script type='text/javascript'>alert('Description must be less than 100 characters.');</script>";
			}
			else
			{
				if($len <4)
				{
					if(is_numeric($_SESSION['product_price']))
					{
					  for($a = 0; $a < $len; $a ++)
					  {
					    if($_FILES["files"]["error"][$a] == 0)
					    {
									$image_size = array();
					        $file_dir = "uploads/";
					        $image_file = $file_dir . basename($_FILES["files"]["name"][$a]);
					        $imageFileType = strtolower(pathinfo($image_file,PATHINFO_EXTENSION));
					        $allowed = array("image/jpg" => "jpg", "image/jpeg" => "jpeg", "image/gif" => "gif", "image/png" => "png");
					        $product_id = $_SESSION['product_id'];
					        $image_type = $_FILES["files"]["type"][$a];
					        // image name is set as seller_id +  product id + category  + photo sequence number
					        $image_name = (string)$_SESSION['user_session']."_".(string)$product_id."_".(string)$_SESSION["product_category"]."_".(string)$a.'.'.$allowed[$image_type];
									$name_tmp = (string)$_SESSION['user_session']."_".(string)$product_id."_".(string)$_SESSION["product_category"]."_".(string)$a;
					        $image_size = $_FILES["files"]["size"][$a];
					        $check = getimagesize($_FILES["files"]["tmp_name"][$a]);
					    if ($image_size > 1048576 * 2)
							{
									echo "<script type='text/javascript'>alert('Sorry, your file is too large. Please provide an image lower than 2MB');</script>";
					        unset($_SESSION['uploaded']);
					        $_SESSION['uploaded'] = 0;
									$error_displayed = true;
					    }
							else if(!array_key_exists($image_type, $allowed))
					    {
									echo "<script type='text/javascript'>alert('Error: Please select a valid file format.');</script>";
									$error_displayed = true;
					    }
							else{
								$_SESSION['uploaded'] = 1;
							}
					    // Check if $_SESSION['uploaded'] is set to 0 by an error
					    if ($_SESSION['uploaded'] == 0) {
								echo "<script type='text/javascript'>alert('Sorry, your file was not uploaded.');</script>";
								$error_displayed = true;
					    // if everything is ok, try to upload file
					    }
					    else {
					        if (move_uploaded_file($_FILES["files"]["tmp_name"][$a], "../Database/tmpimage/".$image_name))
					        {
										$names[$counter] = $image_name;
										$counter = $counter +1 ;
					        }
					        else {
											echo "<script type='text/javascript'>alert('Sorry, there was an error uploading your file1.');</script>";
											$error_displayed = true;
					        }
					      }
					    }
					  }
						if($counter == $len){
							echo "<script type='text/javascript'>alert('Product Succesfully Uploaded');</script>";
							$copy_dir = '';
							$target_dir = '';
							for($a = 0 ; $a <$counter; $a ++)
							{
								$copy_dir = "../Database/tmpimage/".$names[$a];
								$target_dir ="../Database/image/".$names[$a];
								rename($copy_dir,$target_dir);
							}
							$counter = 0 ;
							$auth_user->addProduct();
							$hash_arr = $auth_user->convert_hashtag();
							$auth_user->addHashtag($hash_arr);
						}
						else if($error_displayed != true){
							echo "<script type='text/javascript'>alert('Sorry, there was an error uploading your file2.');</script>";
						}
					}
					else {
						echo "<script type='text/javascript'>alert('Please enter a number for price.');</script>";
					}
				}
				else
				{
					echo "<script type='text/javascript'>alert('Maximum number of product photo is three.');</script>";
				}
			}
		}
		catch(PDOException $e)
		{
			$_SESSION['request_error'] = $e;
		}
	}
// request submit ________________
	if(isset($_POST['btn_request_submit']))
	{
		try
		{
			$_SESSION['request_title'] = strip_tags($_POST['request_title']);
			$_SESSION['request_category'] = strip_tags($_POST['request_category']);
			$_SESSION['request_price'] = strip_tags($_POST['request_price']);
			$_SESSION['request_description'] = strip_tags($_REQUEST['request_description']);
			if (strlen($_SESSION['request_title']) > 20)
			{
				echo "<script type='text/javascript'>alert('Maximum title length is 20 characters.');</script>";
			}
			else if($_SESSION['request_category'] == 0)
			{
				echo "<script type='text/javascript'>alert('Category must be chosen.');</script>";
			}
			else if($_SESSION['request_description'] > 50)
			{
				echo "<script type='text/javascript'>alert('Description must be less than 100 characters.');</script>";
			}
			else
			{
				$auth_user->addRequest($user_id);
			}
		}
		catch(PDOException $e)
		{
			$_SESSION['request_error'] = $e;
		}
	}
// _____
		if(isset($_POST['btn_clear']))
		{
			$_SESSION['product_category'] = $_SESSION['product_price'] =  $_SESSION['product_quality'] = $_SESSION['product_description'] = $_SESSION["product_hashtag"]= "";
			$max_no_img = sizeof($_FILES['files']['name']);
			for($i=1; $i <= $max_no_img; $i++) {
	    	if(empty($_FILES['images']['name'][$i])) {
	        continue;
	    }
}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sell_main</title>
	<link rel="stylesheet" type="text/css" href="../css/Sellpage.css">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">	</script>
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
			<form action="Sellpage.php" method="post" enctype="multipart/form-data">
					<button id= "closeBtn" type="button"></button>
					<div class = "title">
							<input id="priceTextBox" type="text" class="form-control" name="request_title" placeholder="Title" value =<?php if(isset($_SESSION['request_title'])){print_r($_SESSION['request_title']);} ?>>
					</div>
					<div class = "category">
						<select id="categorySelectBar" name="request_category">
										<option value = 0 selected >  </option>
										<option value = 1  > Book </option>
										<option value = 2  > Clothe  </option>
										<option value = 3  > Appliance  </option>
										<option value = 4  > Etc  </option>
							</select>
					</div>
					<div class = "description">
						<textarea id="textareaTextBox" name="request_description" placeholder="Add Description to your product! "><?php if(isset($_SESSION['request_description'])){echo $_SESSION['request_description'];} ?></textarea>
					</div>
				<div class = "price">
						<input id="priceTextBox" type="text" class="form-control" name="request_price" placeholder="price(HKD)" value =<?php if(isset($_SESSION['request_price'])){print_r($_SESSION['request_price']);} ?>>
				</div>
				<br>
				<input id="requestSubmit" class="button" type="submit" name= "btn_request_submit"  value="Add Request" action ="Buypage_loggedin.php" >
			</form>
		</div>
	</div><!--requestModal-->

	<div class="requestedPanel" id="requested">
			<!-- Button to close the overlay navigation -->
	  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

	  <!-- Overlay content -->
	  <div class="overlay-content">
		<?php
		  $stmt = $auth_user->runQuery("SELECT * FROM request");
		  $request_list= array();
		  $c = 0;
		  $stmt->execute(array(":user_id"=>$user_id));
		  while($request_list[$c] = $stmt->fetch(PDO::FETCH_ASSOC)){
		    $c = $c + 1;
		  }
      echo   '<div id="requestedDiv">
          <div id="requested-Book">
          <header id="requested-Book-logo">
            <div id="iconContainer-book">
            </div>
          </header>';
		 for($a = 0; $a < $c ; $a ++)
	   {
		    if($request_list[$a]['category'] == "book")
		    {
		      echo      "<div id='contents'>
		              <div id='requested-contents'>
		                <div id='conts'>
		                  <div id='usertitle'>
		                    <label>Title: </label>
		                    <span>".$request_list[$a]['title']."</span></br>
		                  </div>
		                  <div id='updatedTime'>"
		                    .$request_list[$a]['upload_date'].
		                  "</div>
		                  <div id='userPrice'>
		                    <label>Price: </label>
		                    <span>".$request_list[$a]['price']."</span>
		                  </div></br>
		                  <div id='userdescription'>
		                    <label></br>Description</label>
		                    <div id='userDes'>"
		                      .$request_list[$a]['description'].
		                    "</div>
		                  </div>
		                </div>
		              </div>
		            </div>";
		    }
			}
      echo '</div>
        <div id="requested-Appliance">
        <header id="requested-Appliance-logo">
          <div id="iconContainer-appliance">
          </div>
      </header>';
			for($a = 0; $a < $c ; $a ++)
			{
		    if($request_list[$a]['category'] == "appliance")
		    {
		    echo      '<div id="contents">
		            <div id="requested-contents">
		              <div id="conts">
		                <div id="usertitle">
		                  <label>Title: </label>
		                  <span>'.$request_list[$a]["title"].'</span></br>
		                </div>
		                <div id="updatedTime">'
		                  .$request_list[$a]["upload_date"].
		                '</div>
		                <div id="userPrice">
		                  <label>Price: </label>
		                  <span>'.$request_list[$a]["price"].'</span>
		                </div>
		                <div id="userdescription">
		                  <label>Description</label>
		                  <div id="userDes">'
		                    .$request_list[$a]["description"].
		                  '</div>
		                </div>
		              </div>
		            </div>
		          </div>';
		    }
			}
      echo   '</div>
      <div id="requested-Clothe">
            <header id="requested-Clothe-logo">
              <div id="iconContainer-clothe">
                </div>
              </header>';
		 for($a = 0; $a < $c ; $a ++)
 	   {
		    if ($request_list[$a]['category'] == "clothe")
		    {
		      echo        '<div id="contents">
		              <div id="requested-contents">
		                <div id="conts">
		                  <div id="usertitle">
		                    <label>Title: </label>
		                    <span>'.$request_list[$a]['title']."</span></br>
		                  </div>
		                  <div id='updatedTime'>"
		                    .$request_list[$a]['upload_date'].
		                  '</div>
		                  <div id="userPrice">
		                    <label>Price: </label>
		                    <span>'.$request_list[$a]["price"].'</span>
		                  </div>
		                  <div id="userdescription">
		                    <label>Description</label>
		                    <div id="userDes">'
		                      .$request_list[$a]['description'].
		                    "</div>
		                  </div>
		                </div>
		              </div>
		            </div>";
		    }
			}
      echo     '</div>
          <div id="requested-Etc">
          <header id="requested-Etc-logo">
            <div id="iconContainer-etc">
						Etc
            </div>
          </header>';
		 for($a = 0; $a < $c ; $a ++)
 	   {
		    if ($request_list[$a]['category'] == "etc")
		    {
		      echo    '<div id="contents">
		              <div id="requested-contents">
		                <div id="conts">
		                  <div id="usertitle">
		                    <label>Title: </label>
		                    <span>'.$request_list[$a]['title'].'</span></br>
		                  </div>
		                  <div id="updatedTime">'
		                    .$request_list[$a]['upload_date'].
		                  '</div>
		                  <div id="userPrice">
		                    <label>Price: </label>
		                    <span>'.$request_list[$a]['price'].'</span>
		                  </div>
		                  <div id="userdescription">
		                    <label>Description</label>
		                    <div id="userDes">'
		                      .$request_list[$a]['description'].
		                    "</div>
		                  </div>
		                </div>
		              </div>
		            </div>";
		    }
			}
      echo "</div>
      </div>";
		?>
	  </div>
	</div>


	<div class="input-container">
		<div class="detailPanel">
			<h1 id="detailLabel">Details<h1></br>
			<p id="contentForDetail">@Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<button id="showRequested" onclick="openNav();">See what's requested</button>

		</div>
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

		<form action="Sellpage.php" method="post" enctype="multipart/form-data">
			<div class="upload-Panel">
				<div class = "category">
						<label id="categoryLabel">Category</label></br>
						<select id="categorySelectBar" name="product_category">
										<option value = 0  >   </option>
										<option value = 1  > Book </option>
										<option value = 2  > Clothe  </option>
										<option value = 3  > Appliance  </option>
										<option value = 4  > Etc  </option>
						</select>
				</div>
				<div class="photo">
					<label id="photoLabel">Photo</label></br>
					<p id="recommend">Recommended - photograph always gives a much better response<p></br>

<!--Image IO / Preview ____________________________________________________________________________ -->
		<form id="photoUploadPanel" action="sellpage.php" method="post" enctype="multipart/form-data">
							<label for="files" class="custom-file-upload">
									Add a photo
							</label>
							<input type = "file" multiple name=files[] id="files">
							<br>
							<div id="preview">
							</div>
					<p id="addupto">You can add up to 3 images</p>
<!-- ____________________________________________________________________________ -->
</div><!--photodiv-->
				<div class="description">

					<label id="descriptionLabel">Description</label></br>
					<input id="titleTextBox" name="product_title" type="text" placeholder="Add Title!">
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
								<input type="radio" name="product_quality" value = <?php echo $x+1; ?> <?php if((int)$_SESSION['product_quality'] == $x){ echo 'checked';}?>>
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

			<div class ="clearAndSubmit">

				<label for="submitBtn" id="submitBtnLabel">Upload</label>
				<input id="submitBtn" class="button" type="submit" name= "btn_product_submit"  value="Add Product" action ="sellpage.php" >

				<label for="clearBtn" id="clearBtnLabel">Clear Details</label>
				<input id="clearBtn" class="button" type="submit" name= "btn_clear" id ="clear"  value="Clear Detail" action ="sellpage.php" >



			<div>

		</form>


	</div><!--upload panel-->


</div><!-- input container -->
</body>

</html>
