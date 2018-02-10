<?php

	require_once("../etc/session.php");
	require_once("class.user.php");
	$auth_user = new USER();


	$user_id = $_SESSION['user_session'];

	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));

	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>
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
					<li><a href="Buypage_loggedin.php">buy</a></li>
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


			</form>
		<!--	<form action="Sellpage.php" method="post" enctype="multipart/form-data">
			  <select name="quality">
			    <option value="book" >New </option>
			    <option value="clothe" >Used</option>
			    <option value="appliance" >Appliance</option>
			    <option value="etc" >Etc</option>
			  </select>
			</form>
		-->
			<form action="" method="post" enctype="multipart/form-data">
			  <select name="category" >
					<option value="" >  </option>
			    <option value="book" >Book </option>
			    <option value="clothe" >Clothe</option>
			    <option value="appliance" >Appliance</option>
			    <option value="etc" >Etc</option>
			  </select>
			<input class="button" type="submit"  value="Choose" >
			</form>
			<?php


			$editionerr = $authorerr = "";
			$edition = $author = "";
			if(isset($_POST['category']))
			{
				$category = $_POST['category'];
				if($category == "book"){
					echo '<form action="" method="post" enctype="multipart/form-data">';
					echo '<p><input type="text" id="edition" name="edition"/ placeholder = "Edition"  /></br></p>';
					echo '<p><input type="text" id="author" name="author" placeholder = "Author" </br></p>';
					echo '<input class="button" type="submit"  value="submit" name = "btn-submit" >';
						if(isset($_POST['btn-submit']))
						{
							$edition = strip_tags($_POST['edition']);
							$author = strip_tags($_POST['author']);

							if($edition=="")	{
								$error[] = "<b><font color='red'>provide edition !</font></b>";
							}
							else if($author=="")	{
								$error[] = "<b><font color='red'>provide author !";
							}
							else {
									try{
										
									}
									catch(PDOException $e)
									{
										echo $e->getMessage();
									}
								}
						}
					}
			}
			?>
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
