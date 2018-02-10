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
