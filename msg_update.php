<?php
    include 'dbconfig.php';
    if(isset($_POST["id"]))
    {
    	$id=$_POST["id"];
    	$sql="UPDATE need_medicine SET message='show' WHERE id='$id'";
    	mysqli_query($conn,$sql);
    }
?>