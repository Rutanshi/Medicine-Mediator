<?php
    session_start();
	include 'dbconfig.php';
    if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
        $username=$_SESSION['l_username'];
    else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
        $username=$_SESSION['r_username'];
    
	$medicine_name=$_POST['medicine_name'];
	$medicine_type=$_POST['medicine_type'];
    $quantity=$_POST['quantity'];
    $address=$_POST['address'];
    

    foreach ($_FILES['doc']['name'] as $key => $val) {
        move_uploaded_file($_FILES['doc']['tmp_name'][$key], 'tablets/'.$val);
        $images[]=$val;
    }

$a=implode(",", $images);
  

	$qry="INSERT INTO add_medicine(userid,medicine_name,medicine_type,quantity,address,m_photo) values ('$username','$medicine_name','$medicine_type','$quantity','$address','$a')";
	$r=mysqli_query($conn,$qry);
	if($r)
	{
		//echo "scc";
		header('Location:need_medicine_1.php');
	}
	else
	{
		echo mysqli_error($conn);
	}
?>