<?php 
  session_start();
  include 'dbconfig.php';
  if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
    $username=$_SESSION['l_username'];
  else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
    $username=$_SESSION['r_username'];

   $query="SELECT DISTINCT city FROM medicine_details WHERE quantity>0";
   $r=mysqli_query($conn,$query);
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
  <link rel="stylesheet" type="text/css" href="style.css">

  <script>
  $(document).ready( function () {
load_data();    
    function load_data(is_city){
      var dataTable = $('#myTable').DataTable({
        processing:true,
        serverSide:true,
        order:[],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],

        ajax:{
          url:"fetch_medicine.php",
          type:"POST",
          data:{is_city:is_city}
        },
        columnDefs:[
          {
            targets:[4],
            orderable:false,
          }
        ],
        language: {
        zeroRecords: 'No data available',
        infoEmpty: "No records available - Got it?"
      }
    }); 

      $(document).on('click','.book',function(){
        var id = $(this).attr("id");
        var value = $(this).val();
        window.location.replace("book_1.php?medicine_name=" + id +"&donar_name="+value);
      });

    }

$(document).on('change', '#city', function(){
  var category = $(this).val();
  $('#myTable').DataTable().destroy();
  if(category != '')
  {
   load_data(category);
  }
  else
  {
   load_data();
  }
 });

   
});
</script>
</head>
<body>

  <nav class="navbar fixed-top navbar-expand-lg" style="background-color: #f2f2f2;">
  <div class="container">
    
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
      <a class="navbar-brand" href="#" style="margin-left: 300px">
      <i class="fa fa-user-circle prefix fa-2x"></i>
      <b style="font-size: 25px"><?php echo $username;?></b>
    </a>
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
<div class="content">
  <div class="col-sm-12">
         
      <table class="table" id="myTable">
  <thead class="thead-light">
    <tr>
      <th scope="col">Sr No.</th>
      <th scope="col">Donar name</th> 
      <th scope="col">Medicine Name</th>
      <th scope="col">Medicine Type</th>
      <th scope="col">
        <select name="city" id="city" class="form-control">
          <option value="">All city</option>
          <?php
            while($row=mysqli_fetch_assoc($r))
            {
              echo '<option value="'.$row['city'].'">'.$row['city'].'</option>';
            }
          ?>
        </select>
      </th>
      <th scope="col">Quantity</th>
      <th scope="col"></th>
    </tr>
  </thead>

</table>

  </div>
</div>

</div>


 </body>