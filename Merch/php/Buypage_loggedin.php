<?php
	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$active_detail = $stmt->fetch(PDO::FETCH_ASSOC);

//________
	$request_stmt = $auth_user->runQuery("SELECT * FROM request WHERE user_id=:user_id");
	$request_stmt->execute(array(":user_id"=>$user_id));
	$counter = 0 ;
	$request_list = array();
	while($request_list[$counter] = $request_stmt->fetch(PDO::FETCH_ASSOC)){
		$counter = $counter +1 ;
	}
	$request_num = sizeof($request_list)-1;
	$request_list = array_slice($request_list,0,$request_num);

//___________
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
		$currentpass = strip_tags($_POST['current_password']);
		$newpass = strip_tags($_POST['new_password']);
		$confirmpass = strip_tags($_POST['confirm_password']);
		if(strlen($currentpass)!=0 && strlen($newpass)!=0){
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
	}
// ___________
$min_range = 0 ;
$max_range = 2000;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Buypage_loggedin</title>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/Buypage_loggedin.css">

	<script type="text/javascript" src="../js/Buypage_loggedin.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(){
			var q_value = "default";
			var c_value = "default";
			$("#priceSlider").slider({
					range: true,
					min:0,
					max: 1000,
					values: [<?php echo $min_range; ?>, <?php echo $max_range; ?>],
					slide: function(event,ui){
						$("#min_range").val(ui.values[0]);
						$("#max_range").val(ui.values[1]);
						load_product(ui.values[0],ui.values[1],q_value,c_value);
					}
			});
			load_product(<?php echo $min_range; ?>, <?php echo $max_range; ?>,q_value,c_value);

		var $quality_radios = $('input[name=quality]').change(function ()
		{
    	var q_value = $quality_radios.filter(':checked').val();
			load_product(<?php echo $min_range; ?>, <?php echo $max_range; ?>,q_value,c_value);
		});
		var $category_radios = $('input[name=category]').change(function ()
		{
			var c_value = $category_radios.filter(':checked').val();
			load_product(<?php echo $min_range; ?>, <?php echo $max_range; ?>,q_value,c_value);
		});
/*
		function undo(){
			<?php
			//	$min_range = 0 ;
			//	$max_range = 2000;
			?>
			var q_value = "default";
			var c_value = "default";
			load_product(<?php// echo $min_range; ?>, <?php// echo $max_range; ?>,q_value,c_value);
		});
*/
		function load_product(min_range,max_range,q_value,c_value)
			{
				$.ajax({
						url:"load.php",
						method:"POST",
						data:{min_range:min_range,
								max_range:max_range,
								q_value:q_value,
								c_value:c_value},
						success:function(data)
						{
							$('#load_product').html(data);
						}
				});
			}

			$("input").keyup(function(){
					var search_word = $("input").val();
					$.post("search.php",{
							search_word: search_word
					}, function(data, status){
							$("#suggestion").html(data);
					});
			});
	});

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
	        <span>
						<button class="searchButton"></button>
					</span>
					<span class="searchBar">
						<input id="searchbar" type="text" name="searchbar" placeholder="#COMP2123 #ComputerScience #Kit #..">
					</span>
					<p id="suggestion"></p>
			</div>


			<nav class="tm-nav">
					<ul>
						<li><button id="myInfoButton" data-toggle="modal" data-target="#myInfoDiv">My Info</button></li>
						<li><button id="modalButton" onclick="requestModalfunction();">Request</button></li>
						<li><a href="Sellpage.php">Sell</a></li>
						<li><a href="">My Shopping Bag</a></li>
						<li><a href="log_out.php?logout=true">Log out</a><li>
						<li><button id="tmp" onclick="popUpProduct();">tmpBTN</button></li>
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

	<!--div pops up when conent div in main is clicked-->
	<div id="onClickPopUp">
		<div id="popUpContent">

			<button id= "popupClose"></button>

			<div id="popUpPhoto">
				<div id="slidePanel">
					<img class="slidePhoto" src ="../img/book1.jpg" width="450" height="500">
					<img class="slidePhoto" src ="../img/book2.jpg" width="450" height="500">
					<img class="slidePhoto" src ="../img/book3.jpg" width="450" height="500">
					<button class="sliderDots w3-display-left w3-button" onclick="incrementSliderIndex(-1);">&#10094;</button>
					<button class="sliderDots w3-display-right w3-button" onclick="incrementSliderIndex(1);">&#10095;</button>
				</div>
				
				

				<div class="photoFlex">
					<img class="opac-Photo" src ="../img/book1.jpg" width="130" height="170" onclick="currentSlider(1)">

					<img class="opac-Photo" src ="../img/book2.jpg" width="130" height="170" onclick="currentSlider(2)">

					<img class="opac-Photo" src ="../img/book3.jpg" width="130" height="170" onclick="currentSlider(3)">
				</div>
			</div><!--popUpPhoto-->

			<div id="popUpDes">
				<div id="popUpTitle">

				</div>

				<div id="popUpPrice">

				</div>

				<div id="popUpQuality">

				</div>

				<div id="popUpDescription">

				</div>

			</div><!--pop up description-->
		</div><!--popup content-->
	</div><!--pop up panel-->

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

	<div id="myInfoDiv" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div id="myInfoContentDiv">

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
							<input class="myInfoSubmitBtn" name="btn_myinfo" value="save" type="submit" >
						</div>


					</div><!--user Password div-->

					</form>
				</div><!-- left most div, my information div-->

				<div class="myRequestAndSellDiv">
					<button type="button" class="close" data-dismiss="modal">&times;</button>

					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#requestedContent">My Requests</a></li>
						<li><a data-toggle="tab" href="#mySelling">My products on sale</a></li>
					</ul>

					<div class="tab-content">
						<div id="requestedContent" class="tab-pane fade in active">
							@Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							<?php
							      for($i = 0 ; $i < $request_num ; $i ++)
							      {
							        echo "<div id='requestedItems'>";
							        if($request_list[$i]['category'] == 'book')
							        {
							          echo "<div id='categoryOfRequestedDiv'>".
							            "<div id='iconContainer-book'>".
							          "</div>".
							        "</div>";
							        }
							        else if($request_list[$i]['category'] == "etc")
							        {
							          echo "<div id='categoryOfRequestedDiv'>".
							            "<div id='iconContainer-etc'>".
							              "etc".
							          "</div>".
							        "</div>";
							        }
							        else if($request_list[$i]['category'] == "appliance")
							        {
							          echo "<div id='categoryOfRequestedDiv'>".
							            "<div id='iconContainer-appliance'>".
							          "</div>".
							        "</div>";
							        }
							        else if($request_list[$i]['category'] == "clothe")
							        {
							          echo "<div id='categoryOfRequestedDiv'>".
							            "<div id='iconContainer-clothe'>".
							          "</div>".
							        "</div>";
							        }

							        echo "<div id='requestedPriceAndDesciption'>".
							            "<div id='requestedDescription'>".
							              $request_list[$i]['description'].
							            "</div>".
							            "<div id='requestedPrice'>".
							              $request_list[$i]['price']." HKD".
							            "</div>".
							          "</div>".
										"</div>";
							      }
							  ?>

						</div><!--requested Content div-->

						
						<div id="mySelling" class="tab-pane fade">
							<div  id="sellingContent" class="carousel slide " data-ride="carousel" >

								<!-- Indicators -->
    							<ol class="carousel-indicators">
      								<li data-target="#sellingContent" data-slide-to="0" class="active"></li>
      								<li data-target="#sellingContent" data-slide-to="1"></li>
      								<li data-target="#sellingContent" data-slide-to="2"></li>
    							</ol>

								<div class="carousel-inner">
    								<div class="item active">
      									<img class="d-block " src="../img/book1.jpg" width="160" height="500">
      									<img class="d-block " src="../img/book1.jpg" width="160" height="500">
      									<img class="d-block " src="../img/book1.jpg" width="160" height="500">
      									<div id="selling-title">
      										dddd
										</div>

										<div id="selling-quality">
											dd
										</div>

										<div id="selling-price">
											
										</div>

										<div id="selling-des">
										</div>

										<div id="selling-hashtags">
									
										</div>
    								</div>

    								<div class="item ">
      									<img class="d-block " src="../img/book2.jpg" width="160" height="500">
      									<img class="d-block " src="../img/book2.jpg" width="160" height="500">
    								</div>

    								<div class="item">
      									<img class="d-block " src="../img/book3.jpg" width="160" height="500">
    								</div>
  								</div>

  								<a class="carousel-control-prev" href="#sellingContent" role="button" data-slide="prev">
    								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
    								<span class="sr-only">Previous</span>
  								</a>

  								<a class="carousel-control-next" href="#sellingContent" role="button" data-slide="next">
    								<span class="carousel-control-next-icon" aria-hidden="true"></span>
    								<span class="sr-only">Next</span>
  								</a>
							</div>
							
						</div><!--my selling-->

						
					</div>
					
				</div><!-- right div, show what I requested-->
			</div>
		</div>
	</div><!--my info div-->


	<div class="filterDiv" id="filterdiv">
		<ul>
			<li id="priceSortDiv" onclick="priceFilterDivShow()">
				<div class="btn">
					<img id="barcodeIcon" src="../img/barcode.png" alt="barcode">
				</div>
					<div id="priceSort">price</div>
					<div class="col-md-2">
							<input type='text' name="min_range" id="min_range" class="form-control" value=<?php echo $min_range; ?>>
					</div>
					<div id="priceFilterDiv">
								<div id="priceSlider"></div>
					</div>
					<div class="col-md-2">
							<input type='text' name="max_range" id="max_range"  class="form-control" value=<?php echo $max_range; ?>>
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
				<div class="btn" onclick=undo()>
						<img id="undoIcon" src="../img/undo.png" alt="undo">
						<p id="undo">undo</p>
				</div>
			</li>

		</ul>

	</div><!--fileterDiv-->


	<div class="main" id="load_product">



	</div>





</body>
</html>
