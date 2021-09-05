<?php
	include 'dbconfig.php';
	if(isset($_POST["id"]) && isset($_POST["value"]))
	{
		$id=$_POST['id'];
		$value=$_POST['value'];
		$sql="UPDATE book_order SET quantity='$value' WHERE id='$id'";
		mysqli_query($conn,$sql);
	}
?>