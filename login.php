<?php
   include("includes/connection.php");
   session_start();
   
?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" type="image/png" href="./images/icon.png">
  <title>User Login</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style2.css">
</head>

<body>
  <?php
  if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
      // username and password sent from form 
      
      $username = mysqli_real_escape_string($conn,$_POST['user']);
      $password = mysqli_real_escape_string($conn,$_POST['pass']); 
      
      $query = "SELECT * FROM users WHERE username = '$username'";
      
      $result = mysqli_query($conn , $query) or die (mysqli_error($conn));
if (mysqli_num_rows($result) > 0) 
   {

          while ($row = mysqli_fetch_array($result)) 
          {
            $id = $row['id'];
            $user = $row['username'];
            $pass = $row['password'];
            $name = $row['name'];
            $email = $row['email'];
            $role= $row['role'];
            $course = $row['course'];
            
            if (password_verify($password, $pass )) 
               {
                      $_SESSION['id'] = $id;
                      $_SESSION['username'] = $username;
                      $_SESSION['name'] = $name;
                      $_SESSION['email']  = $email;
                      $_SESSION['role'] = $role;
                      $_SESSION['course'] = $course;
              if($_SESSION['role']=='admin') 
                 {
                 	header('location: Dashboard/');
                 }
              else
              {	   
                                 
              	header('location: UDashboard/');
              }         
              
                }
            else {
      
                    $_SESSION['msg']="Invalid Username or Password !"; ?> 
                           <div class="<?=$_SESSION['isa_error']?>">
                           <i class="<?=$_SESSION['fa fa-times-circle']?>"></i>
                  
                              <?php
                                  echo $_SESSION['msg'];
                                  unset($_SESSION['msg']);
                               ?>
                                </div>
                    <?php
                  }
          }

    }
else 
    {
      $_SESSION['msg']="Invalid Username or Password !"; ?> 
             <div class="<?=$_SESSION['isa_error']?>">
             <i class="<?=$_SESSION['fa fa-times-circle']?>"></i>
                  
          <?php
              echo $_SESSION['msg'];
              unset($_SESSION['msg']);
           ?>
            </div>
           

<?php } 

}
?>  

  <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Sign In </h2>
    <a href="signup.php"><h2 class="underlineHover inactive">Sign Up </h2></a>

    <!-- Login Form -->
    <form method="POST" action="">
      <input type="text" class="fadeIn second" name="user" placeholder="Username" required="">
      <input type="password" class="fadeIn third" name="pass" placeholder="Password" required="">
      <input type="submit" class="fadeIn fourth" value="login" >
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="forgot.php">Forgot Password?</a>
    </div>

  </div>
</div>
</body>

</html>
