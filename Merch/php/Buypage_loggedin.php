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
	<link rel="stylesheet" type="text/css" href="../css/Buypage_v2.css">
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
		</div>

		<div class="tm-container">
			<form action="Buypage_v2.php" method="post">
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
					<li><a href="#">request</a></li>
					<li><a href="Sellpage.php">sell</a></li>
					<li><a href="mycart.php">My Cart</a></li>
					<li><a href="mypage.php">My page</a></li>
          <li><a href="log_out.php?logout=true">Logout</a></li>
				</ul>
		</nav>
  </div><!--searchHeader-->

  <div class="filterDiv">
    <div class="filters tm-container">
      <div class="Price">
        Price
      </div>

      <div class="Quality">
        Quality
      </div>

      <div class="Category">
        Category
      </div>

			<div class="sortButton">
				<button id="sort">sort</button>
			</div>
    </div>
  </div><!--filterDiv-->

	<div class="main">
		<div class="contentBox">
			<img src="../img/book1.jpg" alt="book" width="100%" height="450">
			<footer>
			</footer>
		</div>
		<div class="contentBox">
			<img src="../img/book1.jpg" alt="book" width="100%"  height="90%">
		</div>
		<div class="contentBox">
			<img src="../img/book2.jpg" alt="book" width="100%"  height="90%">
		</div>
		<div class="contentBox">
			<img src="../img/book2.jpg" alt="book" width="100%" height="90%">
		</div>
		<div class="contentBox">
			sdd
		</div>

	</div>





</body>
</html>
