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
				Merch
			</div>

			<div id="barcodeLogo">
				<img src="../img/barcode.png" alt="barcode">
			</div>
		</div>
			<nav class="tm-nav">
				<ul>
					<li><a href="#">request</a></li>
					<li><a href="Buypage.php">buy</a></li>
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
		</div><!--header-->

    <div class="main">
      <div class="requested">
        <div class="test">
          test
        </div>
        <div class="test">
          test
        </div>  <div class="test">
            test
          </div>
      </div>
      <div class="sellerDiv">
        <div class="photoUploadPanel">
          <div class="mainPhoto">

          </div>

          <div class="otherPhoto">
          </div>

          <footer class="photoUploadButtonPanel">

          </footer>

        </div><!--photoUploadPanel-->

      <div class="descriptionPanel">
          <form class="photoDescription" action="" method="post">
            <input id="titleOfProduct" type="text" name="title" value:"title" placeholder="title">
          </form>
      </div><!--descriptionPanel-->

      </div><!--sellerDiv-->
    </div><!--main-->




	</div>
</body>
</html>
