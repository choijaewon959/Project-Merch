<?php
	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$active_detail = $stmt->fetch(PDO::FETCH_ASSOC);
	//print_r($_SESSION);
	if(!isset($_SESSION['request_category']))
	{
		$_SESSION['request_category'] = $_SESSION['request_description'] = $_SESSION['request_price']=  "";
		unset($_SESSION['product_id']);
	}
	$_SESSION['request_error'] = NULL;
	if(isset($_POST['btn_request_submit']))
	{
		try
		{
			$_SESSION['request_category'] = strip_tags($_POST['request_category']);
			$_SESSION['request_price'] = strip_tags($_POST['request_price']);
			$_SESSION['request_description'] = strip_tags($_REQUEST['request_description']);
			$auth_user->addRequest();
		}
		catch(PDOException $e)
		{
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="../js/Buypage_loggedin.js"></script>
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
						<li><button onclick="document.getElementById('requestModal').style.display='block'">Request</button></li>
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
		<form action="Buypage_loggedin.php" method="post" enctype="multipart/form-data">
		<div id="requestContentDiv">
				request
				<button type="button" onclick="document.getElementById('requestModal').style.display='none'">Close</button>
				<div class = "category">
					<select id="categorySelectBar" name="product_category">
									<option value = 1 selected >   </option>
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
			<input class="button" type="submit" name= "btn_request_submit"  value="Add Request" action ="Buypage_loggedin.php" >
		</div>
		</form>
	</div><!--requestModal-->
	<div class="filterDiv">
		<ul>
			<li>
				<div class="btn">
					<img src="../img/barcode.png" alt="barcode">
					<div id="priceSort">price</div>
				</div>
				<div class="sortDropDown">
				</div>
			</li>
			<li>
				<div class="btn">
					<img src="../img/medal.png" alt="medal">
					<div id="qualitySort">quality</div>
				</div>
				<div class="sortDropDown">
				</div>
			</li>
			<li>
				<div class="btn">
					<img src="../img/box.png" alt="blocks">
					<div id="categorySort">category</div>
				</div>

			</li>

			<div class="line">
			</div>

			<li>
				<div class="btn">
						<img id="undoIcon" src="../img/undo.png" alt="undo">
						<div id="undo">undo</div>
				</div>
			</li>
		</ul>

	</div><!--fileterDiv-->


	<div class="main">
		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Pearson Edition Cognitive Psychology</div>
				<div class="updatedDate">06 May</div>
			</div>

			<div class="imgWrap">
				<div class="img_description">
					<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux #happy #dotdttttttttttt</div>
				</div>
				<img class="image" src="../img/book1.jpg" alt="book" width="100%" height="450">
			</div>
			<footer>
				<div class="pricePanel">
					<div id="numOfView">
						15
					</div>
					<div id="eye">
						<img src="../img/view.png" alt="eye">
					</div>

					<div id="price">
						HKD150
					</div>
					<div id="pricetagIcon">
						<img src="../img/pricetag.png" alt="pricetag">
					</div>

				</div>
			</footer>
		</div>
		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Pearson Edition Cognitive Psychology  </div>
				<div class="updatedDate">03 April</div>
			</div>

			<div class="imgWrap">
				<div class="img_description">

					<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux</div>
				</div>
				<img class="image" src="../img/book1.jpg" alt="book" width="100%" height="450">
			</div>
			<footer>

				<div id="numOfView">
					15
				</div>
				<div id="eye">
					<img src="../img/view.png" alt="eye">
				</div>

				<div id="price">
					HKD150
				</div>
				<div id="pricetagIcon">
					<img src="../img/pricetag.png" alt="pricetag">
				</div>





			</footer>
		</div>
		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Science of deadlift  </div>
				<div class="updatedDate">03 April</div>
			</div>

			<div class="imgWrap">
				<div class="img_description">

					<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux</div>
				</div>
				<img class="image" src="../img/book3.jpg" alt="book" width="100%" height="450">
			</div>
			<footer>
				<div class="pricePanel">
					<div id="numOfView">
						15
					</div>
					<div id="eye">
						<img src="../img/view.png" alt="eye">
					</div>

					<div id="price">
						HKD150
					</div>
					<div id="pricetagIcon">
						<img src="../img/pricetag.png" alt="pricetag">
					</div>

				</div>
			</footer>
		</div>
		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Killing a mocking bird </div>
				<div class="updatedDate">03 April</div>
			</div>

			<div class="imgWrap">
				<div class="img_description">

					<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux</div>
				</div>
				<img class="image" src="../img/book2.jpg" alt="book" width="100%" height="450">
			</div>
			<footer>
				<div class="pricePanel">
					<div id="numOfView">
						15
					</div>
					<div id="eye">
						<img src="../img/view.png" alt="eye">
					</div>

					<div id="price">
						HKD150
					</div>
					<div id="pricetagIcon">
						<img src="../img/pricetag.png" alt="pricetag">
					</div>

				</div>
			</footer>
		</div>
		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Pearson Edition Cognitive Psychology  </div>
				<div class="updatedDate">03 April</div>
			</div>
			<div class="imgWrap">
				<div class="img_description">

					<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux</div>
				</div>
				<img class="image" src="../img/book2.jpg" alt="book" width="100%" height="450">
			</div>
			<footer>
				<div class="pricePanel">
					<div id="numOfView">
						15
					</div>
					<div id="eye">
						<img src="../img/view.png" alt="eye">
					</div>

					<div id="price">
						HKD150
					</div>
					<div id="pricetagIcon">
						<img src="../img/pricetag.png" alt="pricetag">
					</div>

				</div>
			</footer>
		</div>

		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Pearson Edition Cognitive Psychology  </div>
				<div class="updatedDate">25 August</div>
			</div>
			<div class="imgWrap">
				<div class="img_description">

					<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux</div>
				</div>
				<img class="image" src="../img/book1.jpg" alt="book" width="100%" height="450">
			</div>
				<footer>
				<div class="pricePanel">
					<div id="numOfView">
						15
					</div>
					<div id="eye">
						<img src="../img/view.png" alt="eye">
					</div>

					<div id="price">
						HKD150
					</div>
					<div id="pricetagIcon">
						<img src="../img/pricetag.png" alt="pricetag">
					</div>

				</div>
			</footer>
		</div>

		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Introduction to COMP2123   </div>
				<div class="updatedDate">03 April</div>
			</div>
			<div class="imgWrap">
				<div class="img_description">

					<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux</div>
				</div>
				<img class="image" src="../img/book2.jpg" alt="book" width="100%" height="450">
			</div>
			<footer>
				<div class="pricePanel">
					<div id="numOfView">
						15
					</div>
					<div id="eye">
						<img src="../img/view.png" alt="eye">
					</div>

					<div id="price">
						HKD150
					</div>
					<div id="pricetagIcon">
						<img src="../img/pricetag.png" alt="pricetag">
					</div>

				</div>
			</footer>
		</div>

		<div class="contentBox">
			<div class="headerInBox">
				<div class="title"> Introduction to mech engi  </div>
				<div class="updatedDate">03 April</div>
			</div>
			<div class="imgWrap">
				<div class="img_description">
										<div class="description"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
					<div class="hashtags"> #COMP2123 #Kit #C++ #Linux</div>
				</div>
				<img class="image" src="../img/book3.jpg" alt="book" width="100%" height="450">
			</div>
			<footer>
				<div class="pricePanel">
					<div id="numOfView">
						15
					</div>
					<div id="eye">
						<img src="../img/view.png" alt="eye">
					</div>

					<div id="price">
						HKD150
					</div>
					<div id="pricetagIcon">
						<img src="../img/pricetag.png" alt="pricetag">
					</div>

				</div>
			</footer>
		</div>

	</div>





</body>
</html>
