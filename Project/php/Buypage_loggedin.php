<?php

	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();


	$user_name = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_name=:user_name");
	$stmt->execute(array(":user_name"=>$user_name));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Buy_main</title>
	<link rel="stylesheet" type="text/css" href="Buypage_css.css">
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Fredoka+One" rel="stylesheet">
</head>
<body>
	<div class="searchHeader">
		<div class="Logo">
			<div id="merchText">
				Merch
			</div>

			<div id="barcodeLogo">
				<img src="images/barcode.png" alt="barcode">
			</div>
		</div>
			<nav class="tm-nav">
				<ul>
					<li><a href="">request</a></li>
					<li><a href="sellpage.php">sell</a></li>
					<li><a href="logout.php?logout=true">log out</a></li>
					</ul>
			</nav>
		<div>

		</div>


		<header>
			<div class="tm-container">
				<form action="search.php" method="post">
					<span class="searchBar">
						<input type="text" name="hashTag" placeholder="#COMP2123 #ComputerScience #Kit #..">

					</span>
					<span>
						<button class="searchButton"></button>
					</span>
				</form>
			</div>

		</header>
		<div class="tm-container">
			<form class="filter" action="filter.php" method="post">
				<span class="price">
					<span id="priceText">Price</span>

					<input class="slider" type="range" min="0" max="1000" name="priceRange">
				</span>

				<span class="rate">
					<span id="rateText">Quality:</span>
					<label for="new">new</label>
					<input type="radio" name="quality" value="new">
					<label for="used">used</label>
					<input type="radio" name="quality" value="used">
					<label for="used">old</label>
					<input type="radio" name="quality" value="old">
				</span>

				<span class="category">
					<span id="categoryText">Category</span>
					<select id="categorySelectBox">
						<option>Book</option>
						<option>clothe</option>
						<option>appliance</option>
						<option>etc</option>
					</select>
				</span>
			</form>
		</div>

	</div>

	<section class="mainBody">
		<ul>
			<li>
				<div class="contentBox">
					<header>
						<div>
							<button id="eye"></button>
							<span id="numberofView">10</span>
							<button id="delete"></button>
							<button id="cart"></button>
						</div>
						<div class="">

						</div>
					</header>
					<div class="photoSection">
						<div id="priceTag">
							HKD 40
						</div>
						<img src="images/book1.jpg" alt="lion" width="100%" height="630">
					</div>

					<footer>
						<div id="heading">
							Perspective on Personality
						</div>
					</footer>
				</div>
				<div class="contentBox">
					<header>
						<div>
							<button id="eye"></button>
							<span id="numberofView">1</span>
							<button id="delete"></button>
							<button id="cart"></button>
						</div>
					</header>
					<div class="photoSection">
						<div id="priceTag">
							HKD 150
						</div>
						<img src="images/book2.jpg" alt="book" width="100%" height="630">
					</div>

					<footer>
						<div id="heading">
							Cognitive psychology
						</div>

					</footer>
				</div>
				<div class="contentBox">
					<header>
						<div>
							<button id="eye"></button>
							<span id="numberofView">23</span>
							<button id="delete"></button>
							<button id="cart"></button>
						</div>
					</header>
					<div class="photoSection">
						<div id="priceTag">
							HKD 10000
						</div>
						<img src="images/book3.jpg" alt="book" width="100%" height="630">

					</div>

					<footer>
						<div id="heading">
							Marketing
						</div>


					</footer>
				</div>



			</li>
		</ul>

		<div class="slideButtonPanel">
			<button id="slideButton"></button>
		</div>

	</section>

	<footer class="tm-footer">
		&copy; copyright Jay Choi 2017
	</footer>


</body>
</html>
