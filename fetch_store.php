<?php
    session_start();
    include 'dbconfig.php';
    if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
        $username=$_SESSION['l_username'];
    else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
    $username=$_SESSION['r_username'];

    $store_name=$_POST['store_name'];
    $my_name=$_POST['my_name'];
    $mobileno=$_POST['mobileno'];
    $city=$_POST['city'];
    $address=$_POST['address'];

     $error= array();
     $file_name =$_FILES['photo']['name'];
     $file_size = $_FILES['photo']['size'];
     $file_tmp = $_FILES['photo']['tmp_name'];
     $file_type = $_FILES['photo']['type'];
     $file_ext = explode('.',$file_name);
    $file_ext = end($file_ext);
    $file_ext = strtolower($file_ext);
     
     move_uploaded_file($file_tmp,"licence/".$file_name);
        $file_name1 = $file_name;  
     
  $qry="INSERT INTO store_details(username,store_name,person_name,mobileno,city,address,licence_photo) values ('$username','$store_name','$my_name','$mobileno','$city','$address','$file_name1')";
  $r=mysqli_query($conn,$qry);
  if($r)
  {
    header('Location:store.php');
  }
  else
  {
    echo mysqli_error($conn);
  }    
?>
