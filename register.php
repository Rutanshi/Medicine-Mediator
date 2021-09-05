<?php
  session_start();
  include 'dbconfig.php';
  if(isset($_POST['signup']))
  {
  $username=$_POST['username'];
  $password=$_POST['password'];
  $name=$_POST['name'];
  $email=$_POST['email'];
  $mobile=$_POST['mobileno'];
  if($_POST['city']=='other')
  {
    $city=$_POST['typecity'];
  }
  else
  {
    $city=$_POST['city'];
  }
  $address=$_POST['address'];
  $query = "select * from register WHERE username='$username'";

  $result = mysqli_query($conn,$query);
  if (mysqli_num_rows($result)>0) 
  {
    $_SESSION['r_loggedin'] = "false";
    $error="Username already taken";
  } 
  else 
  {
    $hash=password_hash($password, PASSWORD_DEFAULT);
    $qry="INSERT INTO register(username,password,name,email,mobile_no,city,address) values ('$username','$hash','$name','$email','$mobile','$city','$address')";
    $r=mysqli_query($conn,$qry);
    if($r)
    {
      //echo "scc";
      $_SESSION['r_loggedin'] = "true";
      $_SESSION['r_username'] = $username;
      header('Location:index_1.php');
    }
    else
    {
      echo mysqli_error($conn);
    }
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

<script>
  $(document).ready(function(){
    $("select.city").change(function(){
        var city = $(this).children("option:selected").val();
        if(city=="other")
        {
          $(".enter_city").show();
        }
        else
        {
          $(".enter_city").hide();
        }
      });
  })
</script>

</head>
<body>

<div class="container col-7">
<br>  

<div class="card bg-light">
<article class="card-body mx-auto col-6">
	<h4 class="card-title mt-3 text-center">Create Account</h4>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" id="newModalForm1" class="needs-validation" novalidate>
	
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="username" class="form-control" placeholder="Username" type="text" autocomplete="off" value="<?php if(isset($_POST["signup"])) echo $_POST["username"];?>" required>
        <div class="invalid-feedback">
          Username must be unique
        </div>
    </div> <!-- form-group// -->
    <p class="text-danger">
      <?php
        if(isset($_POST["signup"]) && $error)
        {
          echo $error;
        }
      ?>
    </p>
    
    <div class="form-group input-group">
    <div class="input-group-prepend">
        <span class="input-group-text"> <i class="fa fa-key"></i> </span>
     </div>
        <input name="password" class="form-control" placeholder="Your Password" type="password" autocomplete="off" value="<?php if(isset($_POST["signup"])) echo $_POST["password"];?>" pattern="^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[\d])(?=.*?[!@#$%^&*_]).{6,30}$" required>
        <div class="invalid-feedback">Password needs to have at least one lower case, one uppercase, one number, one special character,and must be atleast 6 character but no more than 30</div>
    </div> 

    <div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		 </div>
        <input name="name" class="form-control" placeholder="Person name" type="text" autocomplete="off" value="<?php if(isset($_POST["signup"])) echo $_POST["name"];?>" required>
        <div class="invalid-feedback">Please Enter Person name</div>
    </div>

    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		 </div>
        <input name="email" class="form-control" placeholder="Email address" type="email" autocomplete="off" value="<?php if(isset($_POST["signup"])) echo $_POST["email"];?>" required>
        <div class="invalid-feedback">Invalid Email</div>

    </div> <!-- form-group// -->
    
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fas fa-phone-alt"></i> </span>
		 </div>
        <input name="mobileno" class="form-control" placeholder="Phone No" type="tel" autocomplete="off" value="<?php if(isset($_POST["signup"])) echo $_POST["mobileno"];?>" pattern="[7-9]{1}[0-9]{9}" required>
        <div class="invalid-feedback">Invalid Mobile No</div>

    </div>
    
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-building"></i> </span>
		</div>
		<select class="form-control city" name="city" required>
			<option disabled selected>Choose city...</option>

      <?php
        $mysql="SELECT DISTINCT city FROM register";
        $myresult=mysqli_query($conn,$mysql);
        
        while($row=mysqli_fetch_assoc($myresult))
        {
      ?>
         <option value="<?php echo $row["city"];?>" 
            <?php
              if(isset($_POST["signup"]) && $_POST["city"]==$row["city"])
                echo "selected";
            ?> 
          ><?php echo $row["city"];?></option>
      <?php
        }
      ?>
      <option value="other" id="other">Other</option>
		</select>
		<div class="invalid-feedback">Please Select city</div>
	</div>

  <div class="form-group input-group enter_city" style="display: none">
      <div class="input-group-prepend">
        <span class="input-group-text"> <i class="fa fa-building"></i> </span>
     </div>
        <input name="typecity" class="form-control" placeholder="Enter Your City" type="text" autocomplete="off" required>
        <div class="invalid-feedback">Enter City</div>
    </div>

	<div class="form-group input-group">
	  <div class="input-group-prepend">
	    <span class="input-group-text">Address</span>
	  </div>
	  <textarea class="form-control" name="address" placeholder="Your address..." row="3" aria-label="With textarea" required><?php if(isset($_POST['signup']))  echo htmlspecialchars($_POST['address']);?></textarea>
	  <div class="invalid-feedback">Please Enter Your Address</div>
	</div>

    <div class="form-group">
        <button type="submit" name="signup" class="btn btn-primary btn-block"> Create Account  </button>
    </div> <!-- form-group// -->    

    <p class="text-center">Have an account? <a href="login.php">Log In</a> </p>                                                                 
</form>
</article>
</div> <!-- card.// -->

</div> 
</body>
</html>