<?php
	session_start();
  include 'dbconfig.php';
  if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
    $username=$_SESSION['l_username'];
  else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
    $username=$_SESSION['r_username'];


	if(isset($_POST["id"]) && isset($_POST["store_name"]) && isset($_POST["medicine_name"]))
	{
		$id=$_POST["id"];
		$store_name=$_POST["store_name"];
		$medicine_name=$_POST["medicine_name"];

		$mysql="SELECT * FROM book_order INNER JOIN paid_medicine ON book_order.medicineid=paid_medicine.id WHERE username='$username' AND store_name='$store_name' AND medicine_name='$medicine_name'";
		$result=mysqli_query($conn,$mysql);
		if(mysqli_num_rows($result)!=0)
			echo "Already this item in your cart";
		else
		{
			$sql="INSERT INTO book_order(username,medicineid,store_name) VALUES('$username','$id','$store_name')";
			if(mysqli_query($conn,$sql))
				echo "Item added to cart";
		}
		
	}
?>