<?php 
  session_start();
  include 'dbconfig.php';
  if(isset($_SESSION["l_loggedin"]) && isset($_SESSION["l_username"]))
    $username=$_SESSION['l_username'];
  else if(isset($_SESSION["r_loggedin"]) && isset($_SESSION["r_username"]))
    $username=$_SESSION['r_username'];

  if(isset($_GET['placeorder']))
  {
    $query="UPDATE book_order SET status=1 WHERE username='$username'";
    mysqli_query($conn,$query);
    header('Location:paid_medicine.php');
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    
    $(document).ready(function(){
      $("tbody tr").on("change",".quantity",function(){
        var quantity = 0;
          $("tbody tr").each(function () {
            var self = $(this);
            var col_1_value = self.find("input.quantity").val();
            var col_2_value = self.find("td:eq(5)").text().trim();
            var result = col_1_value * col_2_value;
            quantity+=result;  

          });
         document.getElementById("TotalPrice").innerHTML=quantity;
        })


        var quantity = 0;
        $("tbody tr").each(function () {
            var self = $(this);
            var col_1_value = self.find("input.quantity").val();
            var col_2_value = self.find("td:eq(5)").text().trim();
            var result = col_1_value * col_2_value;
            quantity+=result;  
          });
          document.getElementById("TotalPrice").innerHTML=quantity;

          $("tbody tr").on("change",".quantity",function(){
            var id=$(this).attr("id");
            var value=$(this).val();
            $.ajax({
              url:"cart_order.php",
              method:"POST",
              data:{id:id,value:value}
            });
          })

          $("tbody tr").on("click",".delete",function(){
            var id=$(this).attr("id");
            window.location.replace("delete_cart.php?id="+id)
          })

    })
    
  </script>

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
                <h1 class="h2 text-gray-900 mb-4">My Cart</h1>
              </div>
                
            <?php
            $sql = "SELECT book_order.id,book_order.store_name,paid_medicine.medicine_name,paid_medicine.medicine_type,store_details.city,paid_medicine.price,book_order.quantity as b,paid_medicine.quantity as p from book_order INNER JOIN paid_medicine ON book_order.medicineid=paid_medicine.id INNER JOIN store_details ON paid_medicine.storeid=store_details.id WHERE book_order.username='$username'";
            $result=mysqli_query($conn,$sql);


            if(mysqli_num_rows($result)!=0)
            {
              echo '<table class="table table-bordered" id="myTable">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col">Store Name</th>
                        <th scope="col">Medicine Name</th>
                        <th scope="col">Medicine Type</th>
                        <th scope="col">city</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price (Per Unit)</th>
                        <th scope="col">&nbsp</th>
                      </tr>
                    </thead>
                    <tbody>';
          
            while($row=mysqli_fetch_assoc($result))
            {
              echo '
                <tr id='.$row["id"].'>
                  <td>'.$row["store_name"].'</td>
                  <td>'.$row["medicine_name"].'</td>
                  <td>'.$row["medicine_type"].'</td>
                  <td>'.$row["city"].'</td>
                  <td>
                  <input type="number" min=1 max='.$row["p"].' value='.$row["b"].' id='.$row["id"].' name="quantity" class="quantity" style="width: 3em">
                  </td>
                  <td>'.$row["price"].'</td>
                  <td><button type="button" class="btn btn-info delete" id='.$row["id"].'>Remove</button></td>
                </tr>
              ';
            }
          
        echo '</tbody>
      </table>';
        }
        else
        {
          echo '<div class="container bg-light text-center"   style="padding:100px;">
                <h4>Your cart is empty</h4>
              </div>';
        }
      ?>
              
      <div class="container bg-light text-center">
        <h2>Total Price : </h2>
        <h4 id="TotalPrice"></h4>
        <form>
          <button type="submit" class="btn btn-success" id="placeorder" name="placeorder">Place Order</button>
        <form>
      </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

 </body>