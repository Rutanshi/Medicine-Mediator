<?php
	session_start();
    include 'dbconfig.php';

    $column=array("paid_medicine.id","paid_medicine.medicine_name","paid_medicine.medicine_type","store_details.city","store_details.store_name","paid_medicine.quantity","paid_medicine.price");

    $sql = "SELECT paid_medicine.id,paid_medicine.medicine_name,paid_medicine.medicine_type,store_details.city,store_details.store_name,paid_medicine.quantity,paid_medicine.price from paid_medicine INNER JOIN store_details ON paid_medicine.storeid=store_details.id";
    $sql.= " WHERE ";

    $sql.="quantity>0 AND ";

    if(isset($_POST["is_store"]))
    {
        $sql .= "store_name = '".$_POST["is_store"]."' AND ";
    }

    if(isset($_POST["search"]["value"]))
    {

    	$sql.='(medicine_name LIKE "%'.$_POST["search"]["value"].'%" ';
        $sql.='OR person_name LIKE "%'.$_POST["search"]["value"].'%" ';
    	$sql.='OR medicine_type LIKE "%'.$_POST["search"]["value"].'%" ';
    	$sql.='OR city LIKE "%'.$_POST["search"]["value"].'%" ';
        $sql.='OR store_name LIKE "%'.$_POST["search"]["value"].'%" ';
    	$sql.='OR quantity LIKE "%'.$_POST["search"]["value"].'%") ';
    }
    if(isset($_POST["order"]))
    {
    	$sql.='ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
    	$sql.='ORDER BY store_name ASC ';
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
    	$sub_array[]=$row["medicine_name"];
    	$sub_array[]=$row["medicine_type"];
    	$sub_array[]=$row["city"];
        $sub_array[]=$row["store_name"];
    	$sub_array[]=$row["quantity"];
        $sub_array[]=$row["price"];
        $sub_array[]='<button type="button" name="book" class="btn btn-success book" value="'.$row["store_name"].'" id="'.$row["medicine_name"].'" data-id="'.$row["id"].'">Add To Cart</button>';
    	$data[]=$sub_array;
    }

    function get_all_data($conn)
    {
    	$sql2= "SELECT * FROM paid_medicine";
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