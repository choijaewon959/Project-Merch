
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Page Navigation</title>
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
	width: 750px;
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



ul.pagination {
    text-align:center;
    color:#1f447f;
}
ul.pagination li {
    display:inline;
    padding:0 3px;
}
ul.pagination a {
    color:#1f447f;
    display:inline-block;
    padding:5px 10px;
    border:1px solid #1f447f;
    text-decoration:none;
}
ul.pagination a:hover,
ul.pagination a.current {
    background:#1f447f;
    color:#fff;
}

</style>

<!-- Table goes in the document BODY -->



</head>

<body>



	<div id="main">
<br>
<center>
<a href="search.php"><button class="button">SEARCH</button></a>
</center>
<p></p>
<center>

        <table class="altrowstable" id="alternatecolor" >
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
        <?php

				require_once 'dbconfig.php';
				include_once('navigation.php');

				$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
				if ($page <= 0) $page = 1;

				$per_page = 10; // Set how many records do you want to display per page.

				$startpoint = ($page * $per_page) - $per_page;
				$statement = "`member` ORDER BY `id` ASC"; // Change `records` according to your table name.


        $stmt = $db_con->prepare("SELECT * FROM member ORDER BY id DESC LIMIT {$startpoint} , {$per_page}");
        $stmt->execute();
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
		?>

        </tbody>
        </table>
				<br>
<?php

// displaying paginaiton.
echo pagination($statement,$per_page,$page);

 ?>

</center>



    </div>



</body>
</html>
