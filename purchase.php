<?php
    session_start();
    include 'dbconfig.php';
    if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
        $username=$_SESSION['l_username'];
    else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
    $username=$_SESSION['r_username'];

    $donar_name=$_POST['donar_name1'];
    $person_name=$_POST['person_name'];
    $medicine_name=$_POST['medicine_name'];
    $address=$_POST['address'];

     $file_name =$_FILES['profileimg']['name'];
     $file_size = $_FILES['profileimg']['size'];
     $file_tmp = $_FILES['profileimg']['tmp_name'];
     $file_type = $_FILES['profileimg']['type'];
     $file_ext = explode('.',$file_name);
    $file_ext = end($file_ext);
    $file_ext = strtolower($file_ext);


    $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $_SESSION['error']="extension not allowed, please choose a JPEG or PNG file.";
      }
     
     move_uploaded_file($file_tmp,"Corona Report/".$file_name);
        $file_name1 = $file_name;
       
     
  $qry="INSERT INTO need_medicine(userid,donar_name,Name_of_patient,medicine_name,address,corona_report) values ('$username','$donar_name','$person_name','$medicine_name','$address','$file_name1')";
  $r=mysqli_query($conn,$qry);
  if($r)
  {
    header('Location:need_medicine_1.php');
  }
  else
  {
    echo mysqli_error($conn);
  }    
?>
