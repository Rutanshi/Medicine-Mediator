<?php
	include 'dbconfig.php';
	if(isset($_GET["id"]))
	{
		$id=$_GET['id'];
		$sql="DELETE FROM book_order WHERE id='$id'";
		if(mysqli_query($conn,$sql))
		{
			header("Location: cart.php");
		}
	}
?>