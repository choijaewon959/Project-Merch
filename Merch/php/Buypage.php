<!DOCTYPE html>
<html>
<head>
	<title>Buy_main</title>
	<link rel="stylesheet" type="text/css" href="../css/Buypage_css.css">
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
				<img src="../img/barcode.png" alt="barcode">
			</div>
		</div>
			<nav class="tm-nav">
				<ul>
					<li><a href="#">request</a></li>
					<li><a href="Sellpage.php">sell</a></li>
					<li><a href="sign_in.php">sign up</a></li>
					<li><a href="log_in.php">log in</a></li>
				</ul>
			</nav>


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




	<div class="mainBody">
		<aside class="slideButtonPanel-left">
			<button id="slideButton-left"></button>
		</aside>
		<aside class="slideButtonPanel-right">
			<button id="slideButton-right"></button>
		</aside>
		<div class="body_container">
				<div class="contentBox">
						<header>
							<div>
								<button id="eye"></button>
								<span id="numberofView">10</span>
								<button id="delete"></button>
								<button id="cart"></button>
							</div>
						</header>
						<div class="photoSection">

							<img src="../img/book1.jpg" alt="lion" width="100%" height="500">
						</div>

						<footer>
							<div id="heading">
								Textbook for Games and Decisions ECON2214
								Games of Strategy, Avinash Dixit, Susan Skeat
							</div>
							<div id="pricetagIcon">
								<img src="../img/pricetag.png" alt="pricetag">
							</div>

							<div id="price">
								$1500000
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
							<img src="../img/book2.jpg" alt="book" width="100%" height="500">
						</div>

						<footer>
							<div id="heading">
								Cognitive psychology
							</div>
							<div id="pricetagIcon">
								<img src="../img/pricetag.png" alt="pricetag">
							</div>
							<div id="price">
								$150
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

							<img src="../img/book3.jpg" alt="book" width="100%" height="500">

						</div>

						<footer>
							<div id="heading">
								Textbook for Games and Decisions ECON2214
								Games of Strategy, Avinash Dixit, Susan Skeat
							</div>
							<div id="pricetagIcon">
								<img src="../img/pricetag.png" alt="pricetag">
							</div>

							<div id="price">
								$150
							</div>


						</footer>
				</div>


		</div>
	</div>

	<footer class="tm-footer">
		&copy; copyright Jay Choi 2017
	</footer>


</body>
</html>
