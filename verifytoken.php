<?php 
   include 'includes/connection.php'; 
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" type="image/png" href="./images/icon.png">
  <title>Reset Password</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style2.css">
</head>

<body>
  <?php
      if (!empty($_GET['token'])) { 
      $token = mysqli_real_escape_string($conn , $_GET['token']);
      $query = "SELECT token FROM users WHERE token = '$token' ";
      $run = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_num_rows($run) > 0) {
  ?>
  <?php 
     if (isset($_POST['change'])) {
      $password = mysqli_real_escape_string($conn , $_POST['password']);
      $repassword = mysqli_real_escape_string($conn , $_POST['repassword']);
      if (strlen($password) < 6 ) {
          ?>
                    <div class="isa_error">
                        <i class="fa fa-times-circle"></i> <?php
                          echo  "Password should be atleast 6 characters long !"; ?>
                    </div> <?php
      } 
      else if ($password == $repassword) {
      $newpassword = password_hash("$password" , PASSWORD_DEFAULT);
              $query1 = "UPDATE users SET token = '' , password = '$newpassword' WHERE token = '$token' ";
              $run = mysqli_query($conn , $query1) or die(mysqli_error($conn));
              if (mysqli_affected_rows($conn) > 0) {
                  ?>
                    <div class="isa_success">
                        <i class="fa fa-check"></i> <?php
                          echo  "Password Changed Successfully !"; ?>
                    </div> <?php
              }
              else { ?>
                    <div class="isa_error">
                        <i class="fa fa-times-circle"></i> <?php
                          echo  "Error Occured !"; ?>
                    </div> <?php
              }
            }
            else {
                   ?>
                    <div class="isa_error">
                        <i class="fa fa-times-circle"></i> <?php
                          echo  "Passwords do not match !"; ?>
                    </div> <?php
              }
            }
            }
            else {
                  ?>
                    <div class="isa_error">
                        <i class="fa fa-times-circle"></i> <?php
                          echo  "something went wrong ! "; ?> 
                          <a href="forgot.php" style="color: #d80000"> 
                                <?php echo " Try again" 
                                 ?>
                          </a>
                    </div> <?php
            }
            }
            else {
              header("location: index.html");
            }
            ?>


	<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Reset</h2>
    <a href="login.php"><h2 class="underlineHover inactive">Sign In </h2></a>

    <!-- Login Form -->
    <form method="POST" action="">
      <input type="password" class="fadeIn third" name="password" placeholder=" New Password" required="">
      <input type="password" class="fadeIn third" name="repassword" placeholder=" Confirm Password" required="">
      <input type="submit" class="fadeIn fourth" value="Submit" name="change">
    </form>
  </div>
</div>
 <script src="Scripts/script.js"></script> 
  

</body>

</html>