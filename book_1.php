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
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
 <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="style.css">
<script>
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
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
  <a class="nav-link active" href="need_medicine_1.php"><h5>Free Medicines</h5></a>
  <a class="nav-link" href="paid_medicine.php"><h5>Paid Medicines</h5></a>
  <a class="nav-link" href="store.php"><h5>Add Medical Store </h5></a>
  <a class="nav-link" href="#about"><h5>About</h5></a>
</div>

<?php
  $medicine_name=$_GET['medicine_name'];
  $donarname=$_GET['donar_name'];
?>

<div class="content">
  <div class="col-sm-7">
      <div class="card card-primary">
        <div class="card-header bg-primary">
          <h3>Purchase</h3>
        </div>
        <div style="margin: 35px">
        <form action="purchase.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
          <div class="form-group">
            <label for="donarname">Donar Name</label>
            <input type="text" value="<?php echo $donarname;?>" name="donar_name1" class="form-control" id="donarname" readonly>
          </div>
          <div class="form-group">
            <label for="personname">Name Of Patient</label>
            <input type="text" name="person_name" class="form-control" id="personname" autocomplete="off" required>
            <div class="invalid-feedback text-danger">Please Enter a name</div>
          </div>
          <div class="form-group">
            <label for="medicinename">Medicine name</label>
            <input type="text" class="form-control" value="<?php echo $medicine_name;?>" name="medicine_name" id="medicinename" readonly>
          </div>
          
          <?php
            $sql1 = "SELECT address FROM register WHERE username='$username'";
            $result1 = mysqli_query($conn,$sql1);
            $add=mysqli_fetch_assoc($result1);
            $address=$add['address'];
            ?>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Address</label>
            <textarea class="form-control" name="address" id="exampleFormControlTextarea1" rows="3" placeholder="Your address..." required><?php echo htmlspecialchars($address);?></textarea>
            <div class="invalid-feedback text-danger">Please Enter Your Address</div>
          </div>
          <div class="form-group">
            <label for="examplefile">Upload Medical Report</label>
            <input type="file" class="form-control-file border" id="examplefile" name="profileimg" required>
            <div class="invalid-feedback text-danger"><?php if(isset($_SESSION['error'])) echo $_SESSION['error'];?></div>
          </div>
          <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
        </form>
        
      </div>
      </div>

  </div>
</div>

</div>
 </body>