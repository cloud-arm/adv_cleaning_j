
<?php  include('connect.php');

$id=$_GET['id'];



$result = $db->prepare("DELETE FROM salary_advance WHERE  id= '$id' ");
	$result->bindParam(':memid', $id);
	$result->execute();

