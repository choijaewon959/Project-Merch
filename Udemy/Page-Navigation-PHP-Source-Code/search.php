	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Search</title>
			<link href="style.css" rel="stylesheet" type="text/css">

			<!-- Javascript goes in the document HEAD -->
			<script type="text/javascript">
			function altRows(id){
				if(document.getElementsByTagName){

					var table = document.getElementById(id);
					var rows = table.getElementsByTagName("tr");

					for(i = 0; i < rows.length; i++){
						if(i % 2 == 0){
							rows[i].className = "evenrowcolor";
						}else{
							rows[i].className = "oddrowcolor";
						}
					}
				}
			}
			window.onload=function(){
				altRows('alternatecolor');
			}
			</script>

			<!-- CSS goes in the document HEAD or added to your external stylesheet -->
			<style type="text/css">
			table.altrowstable {
				border-width: 1px;
				border-color:  #ddd;
				border-collapse: collapse;
				width: 200px;
			}
			table.altrowstable th {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #ddd;
			}
			table.altrowstable td {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #ddd;
			}
			.oddrowcolor{
				background-color:#fcfcfc;
			}
			.evenrowcolor{
				background-color:#e0dbdb;
			}
			</style>

			<!-- Table goes in the document BODY -->



			</head>

			<body>



				<div id="main2">
<center>

			<br>

				<h1>Search Database Member </h1>
			<form method="post" action="search.php">
				<input type="text"  name="search" placeholder="Search Name" required />
				 	<input value="SEARCH" type="submit"  class="button">
			</form>



		<br>

				<?php if(isset($_POST['search'])){

    $search = $_POST['search'];


		require_once 'dbconfig.php';

		$stmt=$db_con->prepare("SELECT * FROM member WHERE name=:mn");
	$stmt->execute(array(':mn'=>$search));
  $d=$stmt->fetch(PDO::FETCH_ASSOC);
    $nom = $d['name'];

	  if($nom == $search){

			echo '
		<p>

							<table class="altrowstable" id="alternatecolor">
							<thead>
							<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Gender</th>
							<th>Email</th>
							<th>City</th>
							<th>Date</th>

							</tr>
							</thead>
							<tbody>

		';

		?>
							<?php


			$stmt=$db_con->prepare("SELECT * FROM member WHERE name=:mn");
			$stmt->execute(array(':mn'=>$search));
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
						?>
						<tr>
						<td><?php echo $row['id']; ?></td>

						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['city']; ?></td>
						<td><?php echo $row['cdate']; ?></td>


						</tr>
						<?php
					}



		} // end if condition
	else{

			echo '<b><font color="red" >Sorry! record not found.</font></b><br>';

				} // end if isset

			} // End else
					?>

			        </tbody>
			        </table>
							<br>


	</p>

</center>

			    </div>



			</body>
			</html>
