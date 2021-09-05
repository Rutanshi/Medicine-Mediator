<?php
  session_start();
    include 'dbconfig.php';
    if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
        $username=$_SESSION['l_username'];
    else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
        $username=$_SESSION['r_username'];


    if(isset($_POST["save_data"]))
    {
      $id=$_POST["id"];
      $medicine_name=$_POST["save_data"];

      $mysql2="UPDATE medicine_details SET quantity=0 WHERE username='$username' AND medicine_name='$medicine_name'";
      mysqli_query($conn,$mysql2);

      $mysql="UPDATE need_medicine SET message='show' WHERE id='$id'";
      mysqli_query($conn,$mysql); 

      
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
 <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<div class="container">
<!-- Outer Row -->
<div class="row justify-content-center">
  <div class="col-xl-12 col-lg-6 col-md-6">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body bg-info p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-3">
              <div class="text-left">
                <h1 class="h2 text-gray-900 mb-4">Notification</h1>
              </div>
              <?php
                  $sql="SELECT  need_medicine.id,need_medicine.userid,register.name,register.mobile_no,register.city,register.address,need_medicine.medicine_name FROM register INNER JOIN need_medicine ON register.username=need_medicine.userid WHERE status='Approved' AND donar_name='$username' AND message='hide'";


      $result=mysqli_query($conn,$sql);
      while($row=mysqli_fetch_assoc($result))
      { 
        $medicine=$row["medicine_name"];
        $mysql3="SELECT * FROM medicine_details WHERE username='$username' AND medicine_name='$medicine'";
      $myresult3=mysqli_query($conn,$mysql3); 
      $row3=mysqli_fetch_assoc($myresult3);
      $old_quantity1=$row3["quantity"];

        echo '
          <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">You can contact to below details</h4>
                <p><b>Username : </b>'.$row['userid'].'<br><b>Person Name : </b>'. $row['name'].'<br><b>Mobile No : </b>'. $row['mobile_no'].'<br><b>City : </b>'. $row['city'] .'<br><b>address : </b>'.$row['address'].'<br><b>Medicine Name : </b>'.$row['medicine_name'].'</p>
                <hr>
                <h3 class="mb-0">Have you Donated. 
                <form method="post">
                <button type="submit" name="save_data" value='.$row['medicine_name'].' class="btn btn-success yes">Yes</button>
                <button type="submit" class="btn btn-danger no">No</button>
                <input type="hidden" name="id" value='.$row['id'].'>
                </form>
                </h3>
              </div>
        ';

      }
              ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>