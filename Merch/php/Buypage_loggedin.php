<?php
	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$active_detail = $stmt->fetch(PDO::FETCH_ASSOC);
//________
	$product_stmt = $auth_user->runQuery("SELECT * FROM sell_product");
	$product_stmt->execute();
	$counter = 0 ;
	$product_list = array();
	while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
		$counter = $counter +1 ;
	}
	$product_num = sizeof($product_list)-1;
	$product_list = array_slice($product_list,0,$product_num);
//________
	if(!isset($_SESSION['request_category']))
	{
		$_SESSION['request_category'] = "";
		$_SESSION['request_price']=  "";
		$_SESSION['request_quality'] = "";
		$_SESSION['filter_category'] = "1";
		$_SESSION['filter_price_min']=  "0";
		$_SESSION['filter_price_max']=  "100";
		$_SESSION['filter_quality'] = "2";
		unset($_SESSION['product_id']);
	}
	$_SESSION['request_error'] = NULL;
//________
	if(isset($_POST['btn_request_submit']))
	{
		try
		{
			$_SESSION['request_category'] = strip_tags($_POST['request_category']);
			$_SESSION['request_price'] = strip_tags($_POST['request_price']);
			$_SESSION['request_description'] = strip_tags($_REQUEST['request_description']);
			$auth_user->addRequest($user_id);
		}
		catch(PDOException $e)
		{
			$_SESSION['request_error'] = $e;
		}
	}
	if(isset($_POST['btn_myinfo']))
	{
		try
		{
			$_SESSION['my_userName'] = strip_tags($_POST['my_userName']);
			$_SESSION['my_phonenum'] = strip_tags($_POST['my_phonenum']);
			$_SESSION['my_email'] = strip_tags($_POST['my_email']);
			$auth_user->changeInfo($user_id);
		}
		catch(PDOException $e)
		{
			print_r($_SESSION['request_error']);
			$_SESSION['request_error'] = $e;
		}
	}
	if(isset($_POST['btn_changepwd']))
	{
		try
		{
			$currentpass = strip_tags($_POST['current_password']);
			$newpass = strip_tags($_POST['new_password']);
			$confirmpass = strip_tags($_POST['confirm_password']);
			if(strlen($newpass) >5){
				if($newpass == $confirmpass)
				{
					$auth_user->changePwd($currentpass,$newpass,$user_id);
				}
				else
				{
					echo "<script type='text/javascript'>alert('Confirm password does not match.');</script>";
				}
			}
			else
			{
				echo "<script type='text/javascript'>alert('Password must be at least 6 charaters');</script>";
			}
		}
		catch(PDOException $e)
		{
			print_r($_SESSION['request_error']);
			$_SESSION['request_error'] = $e;
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Buypage_loggedin</title>
	<link rel="stylesheet" type="text/css" href="../css/Buypage_loggedin.css">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="../js/Buypage_loggedin.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(){
		var target = document.getElementById("main");
		var xhr = new XMLHttpRequest();
		xhr.open('GET','display_product.php',true);
		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		if(xhr.readyState == 4 && xhr.status == 200){
				var result = xhr.responseText ;
				console.log(result);
				var json = JSON.parse(xhr.responseText);
				append_product(target,result);
			}
		}
	});
	function append_product(div,product_html){
		var temp = document.createElement('div');
		temp.innerHTML = product_html ;
		var class_name = temp.firstElementChild.className ;
		var items = temp.getElementByClassName(class_name);

		var len = items.length ;
		for(i = 0 ; i <len ; i ++){
			div.appendChild(items[0]);
		}
	}
</script>

</head>

<body>
	<div id="stickedToTop">
		<div class="searchHeader">
			<div class="Logo">
				<div id="merchText">
					<a href="">Merch</a>
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
						<li><button id="myInfoButton" onclick="myInfofunction();">My Info</button></li>
						<li><button id="modalButton" onclick="requestModalfunction();">Request</button></li>
						<li><a href="Sellpage.php">Sell</a></li>
						<li><a href="">My Shopping Bag</a></li>
						<li><a href="log_out.php?logout=true">Log out</a><li>
					</ul>
			</nav>
	  </div><!--searchHeader-->


		<div class="filterAndShoppingCart">
			<div class="cartDiv">

				<img id="shopping_bag" src="../img/shopping-bag.png" alt="shopping bag">
				<div>
					<span id="dragAndDrop">Drag & Drop</span>
					 <span id="textForCart1">the items in the shopping bag</span>
					 <!--
					 <span id="click">Click </span>
					 <span id="textForCart2">the bag to see the interested items</span>
				 -->
				</div>

			</div><!--cartDiv-->

		</div><!--filter and Shopping Cart-->
	</div><!--stickedToTop-->

	<div id="requestModal">
		<div id="requestContentDiv">
			<form action="Buypage_loggedin.php" method="post" enctype="multipart/form-data">
					<button id= "closeBtn" type="button"></button>
					<div class = "category">
						<select id="categorySelectBar" name="request_category">
										<option value = 0 selected >  </option>
										<option value = 1  > Book  </option>
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

	<div id="myInfoDiv">
		<div id="myInfoContentDiv">
			<button id= "accountDivCloseBtn" type="button"></button></br>

			<div class="informationDiv">
			<form id="myInfoPanel" action="Buypage_loggedin.php" method="post" enctype="multipart/form-data">
				<label id="myInfoTitle">My Info</label>

				<div class="UsernameDiv">
					<label >My Username</label></br>
					<input class="userNameInput" type ="text" name="my_userName" autocomplete="off" value=<?php if(!isset($_SESSION['my_userName'])){echo $active_detail['user_name'];}else{echo $_SESSION['my_userName'];} ?>>

				</div><!--User name div-->

				<div class="UserPhoneNumberDiv">
					<label>Phone Number</label></br>
					<input class="phoneNumberInput" type="text" name="my_phonenum" autocomplete="off" value=<?php if(!isset($_SESSION['my_phonenum'])){echo $active_detail['phone_num'];}else{echo $_SESSION['my_phonenum'];} ?>>
				</div><!--User phone number div-->

				<div class="UserEmailDiv">
					<label>Email</label></br>
					<input class="emailInput" type="text" name="my_email" autocomplete="off" value= <?php if(!isset($_SESSION['my_email'])){echo $active_detail['email'];}else{echo $_SESSION['my_email'];}  ?>>
				</div><!--User email div-->

			</form>

				<form id="myInfoPanel" action="Buypage_loggedin.php" method="post" enctype="multipart/form-data">

				<div id="UserPasswordDiv">
					<div class="pwLabelDiv">
						<label id="PWLABEL">Password</label>
					</div>


					<div class="currnetPWDiv">
						<input class="passwordInput" type="password"  name="current_password" autocomplete="off" />
						<span class="floatLabel">Current Password</span>
					</div><!--current pw div-->

					<div class="newPWDiv">
						<input class="newPasswordInput" type="password"  name="new_password" autocomplete="off" />
						<span class="floatLabel">New Password</span>
					</div><!--new password div-->

					<div class="confirmPWDiv">
						<input class="confirmPasswordInput" type="password"  name="confirm_password" autocomplete="off" />
						<span class="floatLabel">Confirm Password</span>
					</div><!--confirm new password div-->

					<div>
						<input class="myInfoSubmitBtn" name="btn_changepwd" value="save" type="submit" >
					</div>


				</div><!--user Password div-->

				</form>
			</div><!-- left most div, my information div-->

			<div class="myRequestAndSellDiv">
					<label>My Request</label>

					<div id="requestedContent">
						<div id="">
						</div>
					</div>
			</div><!-- right div, show what I requested-->


		</div>

	</div>

	<div class="filterDiv" id="filterdiv">
		<ul>
			<li id="priceSortDiv" onclick="priceFilterDivShow()">
				<div class="btn">
					<?php print_r($_SESSION['request_error']); ?>
					<img id="barcodeIcon" src="../img/barcode.png" alt="barcode">
					<div id="priceSort">price</div>

					<div id="priceFilterDiv">
						<form id= "filter_price" runat = "server">
								<input id="priceSlider" type="range" min="1" max="100" value="50" class="slider">
						</form>
					</div>
				</div>

			</li>

			<li id="qualitySortDiv" onclick="qualityFilterDivShow()">
				<div class="btn">
					<img id= "medalIcon" src="../img/medal.png" alt="medal">
					<div id="qualitySort"> quality</div>
					<div id= "qualityFilterDiv">
						<form action="Buypage_loggedin.php">
							<input type="radio" name="quality" value="defaut" checked> No preference</input><br>
 						  <input type="radio" name="quality" value="New"> New</input><br>
						  <input type="radio" name="quality" value="Used"> Used</input><br>
						  <input type="radio" name="quality" value="Old"> Old</input><br>
						</form>
					</div>
				</div>
			</li>

			<li id="categorySortDiv" onclick="categoryFilterDivShow()">
				<div class="btn">
				<img id="boxIcon" src="../img/box.png" alt="blocks">
					<div id="categorySort"> category</div>
					<div id="categoryFilterDiv">
						<form action="Buypage_loggedin.php">
							<input type="radio" name="category" value="defaut" checked> No preference</input><br>
						  <input type="radio" name="category" value="Book"> Book</input><br>
						  <input type="radio" name="category" value="Clothe"> Clothe</input><br>
						  <input type="radio" name="category" value="Appliance"> Appliance</input> <br>
							<input type="radio" name="category" value="Etc"> Etc</input></br>
						</form>
					</div>
				</div>
			</li>


			<div class="line">
			</div>


			<li>
				<div class="btn">
						<img id="undoIcon" src="../img/undo.png" alt="undo">
						<p id="undo">undo</p>
				</div>
			</li>

		</ul>

	</div><!--fileterDiv-->


	<div class="main">
	<?php

	  for($i = 0 ; $i < $product_num ; $i ++){
			$id = $product_list[$i]['product_id'];
			$hash_stmt = $auth_user->runQuery("SELECT * FROM hashtag WHERE product_id=:product_id");
			$hash_stmt->execute(array(":product_id"=>$id));
			$counter = 0;
			$hash_list = array();
			$hash_out = '#';
			while($hash_list[$counter] = $hash_stmt->fetch(PDO::FETCH_ASSOC)){
				$hash_out .=$hash_list[$counter]['hashtag']."#";
				$counter = $counter +1 ;
			}
			$hash_out = substr($hash_out,0,-1);
		echo "<div class='contentBox'>";
		echo	"<div class='headerInBox'>.
				<div class='title'>".$product_list[$i]['title']."</div>".
				"<div class='updatedDate'>"."Upload Date ".$product_list[$i]['upload_date']."</div>".
			"</div>".

			"<div class='imgWrap'>".
				"<div class='img_description'>".
					"<div class='description'>".$product_list[$i]['description'].'</div>'.
					'<div class="hashtags">'.$hash_out."</div>".
				'</div>'.
				"<img class='image' src=".$auth_user->image_dir(1,$i+1)." alt='book' width=200px height=150px>".
			"</div>".
			"<footer>".
				"<div class='pricePanel'>".
					"<div id='numOfView'>".
						"15".
					"</div>".
					"<div id='eye'>".
						"<img src='../img/view.png' alt='eye'>".
					"</div>".
					"<div id='price'>".
						(string)$product_list[$i]['price']." HKD".
					"</div>".
				"</div>".
			"</footer>".
		"</div>";
	}
	?>


	</div>



</body>
</html>
