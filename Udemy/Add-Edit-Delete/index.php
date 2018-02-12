
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Insert, Update, Delete using jQuery, PHP and MySQL</title>
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



	<div id="main">
<br>
<center>
 <a href="register.php"><button class="button">Add Member</button></a>
</center>
<center>
	<h1>Database Member Information</h1>
        <table class="altrowstable" id="alternatecolor">
        <thead>
        <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Gender</th>
				<th>Email</th>
				<th>City</th>
		    <th>Date</th>
        <th>edit</th>
        <th>delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require_once 'dbconfig.php';

        $stmt = $db_con->prepare("SELECT * FROM member ORDER BY id DESC");
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

			<td align="center">
			<a   href="edit.php?eid=<?php echo $row['id']; ?>" title="Edit">
			<img src="img/edit.png" width="20px" />
            </a></td>
			<td align="center"><a   href="delete.php?id=<?php echo $row['id']; ?>" title="Delete">
			<img src="img/delete.png" width="20px" />
            </a></td>
			</tr>
			<?php
		}
		?>

        </tbody>
        </table>
				<br>


</center>



    </div>



</body>
</html>
