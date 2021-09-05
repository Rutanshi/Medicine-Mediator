<?php
	session_start();
    include 'dbconfig.php';
    if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
        $username=$_SESSION['l_username'];
    else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
        $username=$_SESSION['r_username'];

    $column=array("id","username","medicine_name","medicine_type","city","quantity");

    $sql = "SELECT * from medicine_details";
    $sql.= " WHERE ";
    

    $sql.="quantity>0 AND ";

    if(isset($_POST["is_city"]))
    {
    	$sql .= "city = '".$_POST["is_city"]."' AND ";
    }

    if(isset($_POST["search"]["value"]))
    {

    	$sql.='(medicine_name LIKE "%'.$_POST["search"]["value"].'%" ';
        $sql.='OR username LIKE "%'.$_POST["search"]["value"].'%" ';
    	$sql.='OR medicine_type LIKE "%'.$_POST["search"]["value"].'%" ';
    	$sql.='OR city LIKE "%'.$_POST["search"]["value"].'%" ';
    	$sql.='OR quantity LIKE "%'.$_POST["search"]["value"].'%") ';
    }
    if(isset($_POST["order"]))
    {
    	$sql.='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
    	$sql.='ORDER BY id ASC ';
    }
    $sql1='';
    if($_POST["length"] != -1)
    {
    	$sql1.='LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    
    $number_filter_row=mysqli_num_rows(mysqli_query($conn,$sql));
    $result=mysqli_query($conn,$sql . $sql1);
    $data=array();
    while($row=mysqli_fetch_array($result))
    {
    	$sub_array=array();
    	$sub_array[]=$row["id"];
        $sub_array[]=$row["username"];
    	$sub_array[]=$row["medicine_name"];
    	$sub_array[]=$row["medicine_type"];
    	$sub_array[]=$row["city"];
    	$sub_array[]=$row["quantity"];
        $sub_array[]='<button type="button" name="book" class="btn btn-danger book" value="'.$row["username"].'" id="'.$row["medicine_name"].'">Book</button>';
    	$data[]=$sub_array;
    }

    function get_all_data($conn)
    {
    	$sql2= "SELECT * from medicine_details";
    	$result2=mysqli_query($conn,$sql2);
    	return mysqli_num_rows($result2);
    }
    $output=array(
    	"draw"=>intval($_POST["draw"]),
    	"recordsTotal"=>get_all_data($conn),
    	"recordsFiltered"=>$number_filter_row,
    	"data"=>$data
    );
    echo json_encode($output);
?>