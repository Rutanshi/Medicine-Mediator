<?php 
  session_start();
  include 'dbconfig.php';
  if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
    $username=$_SESSION['l_username'];
  else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
    $username=$_SESSION['r_username'];

   $query1="SELECT DISTINCT store_name FROM store_details WHERE status='Approved'";
   $r1=mysqli_query($conn,$query1);
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
    function load_data(is_store){
      var dataTable = $('#myTable').DataTable({
        processing:true,
        serverSide:true,
        order:[],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],

        ajax:{
          url:"fetch_paid_medicine.php",
          type:"POST",
          data:{is_store:is_store}
        },
        columnDefs:[
          {
            targets:[3],
            orderable:false,
          },
          {
            targets:[6],
            orderable:false,
          }
        ],
        language: {
        zeroRecords: '<h2 class="text-danger">There is no medicine you searched for in this city</h2><h3 class="text-danger">Try to find in another city</h3>',
        infoEmpty: "No records available - Got it?"
      }
    }); 

      $(document).on('click','.book',function(){
        var id = $(this).data("id");
        var store_name = $(this).val();
        var medicine_name=$(this).attr("id");
        $.ajax({
          url:"book_order.php",
          method:"POST",
          data:{id:id,store_name:store_name,medicine_name:medicine_name},
          success:function(data){
            if(data=="Already this item in your cart")
            {
              alert(data);
            }
            else
            {
               alert(data);
              setInterval('location.reload()', 500);
            }
          }
        });
      });

    }

$(document).on('change', '#store_name' , function(){
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
  <a class="nav-link" href="need_medicine_1.php"><h5>Free Medicines</h5></a>
  <a class="nav-link active" href="paid_medicine.php"><h5>Paid Medicines</h5></a>
  <a class="nav-link" href="store.php"><h5>Add Medical Store </h5></a>
  <a class="nav-link" href="#about"><h5>About</h5></a>
</div>
<div class="content">
  <div class="col-sm-12">
         
      <table class="table" id="myTable">
  <thead class="thead-light">
    <tr>
      <th scope="col">Medicine Name</th>
      <th scope="col">Medicine Type</th>
      <th scope="col">city</th>
      <th scope="col">
        <select name="store_name" id="store_name" class="form-control drop">
          <option value="">All Medical Store</option>
          <?php
            while($row1=mysqli_fetch_assoc($r1))
            {
              echo '<option value="'.$row1['store_name'].'">'.$row1['store_name'].'</option>';
            }
          ?>
        </select>
      </th>
      <th scope="col">Quantity</th>
      <th scope="col">Price (Per Unit)</th>
      <th scope="col"></th>
    </tr>
  </thead>

</table>

  </div>
</div>

</div>


 </body>