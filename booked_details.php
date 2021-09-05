<?php 
  session_start();
  include 'dbconfig.php';
  if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
    $username=$_SESSION['l_username'];
  else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
    $username=$_SESSION['r_username'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>


<div class="container">
<!-- Outer Row -->
<div class="row justify-content-center">
  <div class="col-xl-12 col-lg-6 col-md-6">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-12">
            <div class="p-3">
              <div class="text-left">
                <h1 class="h2 text-gray-900 mb-4">Order Details</h1>
              </div>
                
            <?php
            $sql = "SELECT * from need_medicine WHERE userid='$username' AND message='show'";
            $result=mysqli_query($conn,$sql);

              echo '<table class="table table-bordered" id="myTable">
                    <thead class="thead-light">
                      <tr>
                      <td colspan="3">
                        <ul class="nav nav-tabs">
                          <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="myorder.php">Donated Detail</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link active" href="#">Booked Detail</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="purchased_details.php">Purchased Detail</a>
                          </li>
                        </ul>
                        </td>
                      </tr>
                      <tr>
                        <th scope="col">Donar Name</th>
                        <th scope="col">Medicine Name</th>
                        <th scope="col">Date</th>
                      </tr>
                    </thead>
                    <tbody>';
          
            while($row=mysqli_fetch_assoc($result))
            {
              echo '
                <tr>
                  <td>'.$row["donar_name"].'</td>
                  <td>'.$row["medicine_name"].'</td>       
                  <td>'.$row["Date"].'</td>   
                </tr>
              ';
            }
          
        echo '</tbody>
      </table>';
        
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