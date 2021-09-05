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
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">

<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    
    var forms = document.getElementsByClassName('needs-validation');
    
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
<script type="text/javascript">
  $(function() {
     $( "#medicinename" ).autocomplete({
       source: 'ajax-db-search.php',
     });
  });
</script>
</head>
<body>
  <nav class="navbar fixed-top navbar-expand-lg" style="background-color: #f2f2f2;">
  <div class="container">
    <a class="navbar-brand" href="#" style="margin-left: 300px">
      <i class="fa fa-user-circle prefix fa-2x"></i>
      <b style="font-size: 25px"><?php echo $username;?></b>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
       <?php
       $sql="SELECT * FROM register INNER JOIN need_medicine ON register.username=need_medicine.userid WHERE status='Approved' AND donar_name='$username' AND message='hide'";
      $result=mysqli_query($conn,$sql);
      $count=mysqli_num_rows($result);

      $mysql="SELECT * from book_order WHERE username='$username'";
      $myresult=mysqli_query($conn,$mysql);
      $mycount=mysqli_num_rows($myresult);
    ?>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link" href="read_msg.php">
          <i class="fas fa-bell fa-2x">
          </i>
          <?php
            if($count==0)
            {
                echo '<span class="badge badge-danger" id="count"></span>';
            }
            else
            {
                echo '<span class="badge badge-danger" id="count">'.$count.'</span>';
            }
          ?>
        </a>
      </li>
      <li>
          <a class="nav-link" href="cart.php">
            <i class="fas fa-shopping-cart fa-2x"></i>
            <?php
            if($mycount==0)
            {
                echo '<span class="badge badge-danger" id="count"></span>';
            }
            else
            {
                echo '<span class="badge badge-danger" id="count">'.$mycount.'</span>';
            }
          ?>
          </a>
        </li>
        <li>
          <a class="nav-link" href="myorder.php">
            <button type="button" class="btn btn-outline-primary">My Order</button>
          </a>
        </li>
        <li>
          <a class="nav-link" href="logout.php">
            <button type="button" class="btn btn-outline-primary">Logout</button>
          </a>
        </li>
    </ul>
  </div>
  </div>
</nav>

<div class="sidebar">
  <h2 class="text-primary text-lg-center" style="font-family: Cursive;">Medicine Mediater</h2>
  <br>
  <a class="nav-link" href="index_1.php"><h5>Home</h5></a>
  <a class="nav-link" href="add_medicine_1.php"><h5>Donate Medicines</h5></a>
  <a class="nav-link" href="need_medicine_1.php"><h5>Free Medicines</h5></a>
  <a class="nav-link" href="paid_medicine.php"><h5>Paid Medicines</h5></a>
  <a class="nav-link active" href="store.php"><h5>Add Medical Store </h5></a>
  <a href="#about"><h5>About</h5></a>
</div>

<div class="content">
  <div class="col-sm-7">
  <div class="card card-primary">
        <div class="card-header bg-primary">
          <h3>Register Medical Store</h3>
        </div>
        <div style="margin: 35px">
        <form action="fetch_store.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
          
          <div class="form-group">
            <label>Medical Store Name</label>
            <input type="text" name="store_name" class="form-control" autocomplete="off"  placeholder="Enter Name of medical store" required>
            <div class="invalid-feedback text-danger">Please Enter Name of Your Store</div>
          </div>

          <div class="form-group">
            <label>Your Name</label>
            <input type="text" name="my_name" class="form-control" autocomplete="off"  placeholder="Enter Your Name" required>
            <div class="invalid-feedback text-danger">Please Enter Your Name</div>
          </div>

          <div class="form-group">
            <label>Mobile No.</label>
            <input type="tel" name="mobileno" class="form-control" autocomplete="off"  placeholder="Enter Your Mobile No" required>
            <div class="invalid-feedback text-danger">Please Enter Your mobile No</div>
          </div>

          <?php
            $sql1 = "SELECT city,address FROM register WHERE username='$username'";
            $result1 = mysqli_query($conn,$sql1);
            $add=mysqli_fetch_assoc($result1);
            $address=$add['address'];
            $city=$add['city'];
            ?>

          <div class="form-group">
            <label>City</label>
            <input type="text" name="city" class="form-control" autocomplete="off"  placeholder="Enter City" required>
            <div class="invalid-feedback text-danger">Please Enter City</div>
          </div>

          <div class="form-group">
            <label>Address of Your Shop</label>
            <textarea class="form-control" name="address" rows="3" placeholder="Your address..." required></textarea>
            <div class="invalid-feedback text-danger">Please Enter your address</div>
          </div>
          
          <div class="form-group">
            <label>Upload licence photo</label>
            <input type="file" class="form-control-file border" name="photo" required>
            <div class="invalid-feedback text-danger">Please upload your licence photo here</div>
          </div>

          <button type="submit" name="profileimg" class="btn btn-primary btn-lg btn-block">Submit</button>
        </form>
      </div>
      </div>
    </div>
</div>

 </body>