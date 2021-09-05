<?php 
    session_start();
  include 'dbconfig.php';
  if(isset($_POST['login']))
  {
    $name=$_POST['username'];
    $password=$_POST['password'];

    $qry="select * from register where username = '$name'";
    $r=mysqli_query($conn,$qry);

    if(mysqli_num_rows($r)>0)
    {
      while($row=mysqli_fetch_assoc($r))
      {
        if(password_verify($password, $row['password']))
        {
          $login=true;
          $_SESSION['l_loggedin'] = "true";
          $_SESSION['l_username'] = $name;
          header("Location: index_1.php");
        }
        else
        {
          $_SESSION['l_loggedin'] = "false";
          $error="Invalid Credential";
          //echo mysqli_error($conn);
        }
      }
    }
    else
    {
      $_SESSION['l_loggedin'] = "false";
      $error="Invalid Credential";
      //echo mysqli_error($conn);
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/fontawesome.min.css"/>
<script src="https://cdn.rawgit.com/PascaleBeier/bootstrap-validate/v2.2.0/dist/bootstrap-validate.js" ></script>

<script>

(function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
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

<div class="container col-7">
<br>  

<div class="card bg-light">
<article class="card-body mx-auto col-6">
  <h4 class="card-title mt-3 text-center">Login</h4>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="newModalForm1" class="needs-validation" novalidate>
  
  <div class="form-group input-group">
    <div class="input-group-prepend">
        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
     </div>
        <input name="username" class="form-control" placeholder="User name" type="text" autocomplete="off" value="<?php if(isset($_POST['login'])) echo $_POST['username'];?>" required>
        <div class="invalid-feedback">
          Please Enter Unique Username
        </div>
    </div> <!-- form-group// -->

   
    <div class="form-group input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"> <i class="fa fa-key"></i> </span>
     </div>
        <input name="password" class="form-control" placeholder="Enter Your Password" type="password" autocomplete="off" value="<?php if(isset($_POST['login'])) echo $_POST['password'];?>" required>
        <div class="invalid-feedback">Password needs to have at least one lower case, one uppercase, one number, one special character,and must be atleast 6 character but no more than 30</div>

    </div> <!-- form-group// --> 


    <div class="form-group">
        <button type="submit" name="login" class="btn btn-primary btn-block"> Login  </button>
    </div> <!-- form-group// -->    

    <p class="text-danger text-center"><?php if(isset($_POST['login'])) echo $error;?></p>
    <p class="text-center">Create an account? <a href="register.php">Sign Up</a> </p>                                                                 
</form>
</article>
</div> <!-- card.// -->

</div> 
</body>
</html>