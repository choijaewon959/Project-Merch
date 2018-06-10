<?php
	require_once("class.user.php");
	$auth_user = new USER();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Buypage_needlog</title>
	<link rel="stylesheet" type="text/css" href="../css/Buypage_needlog.css">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
	<script type="text/javascript" src="../js/Buypage_needlog.js"></script>
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
							<input id="searchbar" type="text" name="hashTag" placeholder="#COMP2123 #ComputerScience #Kit #..">
						</span>
						<p id="suggestion"></p>
				</div>


				<nav class="tm-nav">
						<ul>
							<li><a href="log_in.php">Request</a></li>
							<li><a href="log_in.php">Sell</a></li>
							<li><a href="sign_in.php">Sign up</a></li>
							<li><a href="log_in.php">Log in</a></li>
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
			</div>
		</div><!--stickedToTop-->

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
			<?php
				$product_stmt = $auth_user->runQuery("SELECT * FROM sell_product");
				$product_stmt->execute();
				$counter = 0 ;
				$product_list = array();
				while($product_list[$counter] = $product_stmt->fetch(PDO::FETCH_ASSOC)){
					$counter = $counter +1 ;
				}
				$product_num = sizeof($product_list)-1;
				$product_list = array_slice($product_list,0,$product_num);

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
