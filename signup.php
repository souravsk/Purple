<?php include 'includes/connection.php';?>
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" type="image/png" href="./images/icon.png">
  <title>User Signup</title>
      <link rel="stylesheet" href="css/style.css"> 
      <link rel="stylesheet" href="css/style2.css">
</head>

<body>
	<?php
if (isset($_POST['signup'])) {
require "gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
  'username'    => 'required|alpha_numeric|max_len,20|min_len,4',
  'name'        => 'required|alpha_space|max_len,30|min_len,5',
  'email'       => 'required|valid_email',
  'password'    => 'required|max_len,50|min_len,6',
));
$gump->filter_rules(array(
  'username' => 'trim|sanitize_string',
  'name'     => 'trim|sanitize_string',
  'password' => 'trim',
  'email'    => 'trim|sanitize_email',
  ));
$validated_data = $gump->run($_POST);
if($validated_data === false) {
  ?>
    <div class="isa_error">
      <i class="fa fa-times-circle"></i>
      <?php echo $gump->get_readable_errors(true); ?> 
  </div>

        
  <?php
}
else if ($_POST['password'] !== $_POST['repassword']) 
{?>
	<div class="isa_error">
             <i class="fa fa-times-circle"></i> <?php
  echo  "Passwords do not match."; ?>
  </div>
<?php  
}
else {
      $username = $validated_data['username'];
      $checkusername = "SELECT * FROM users WHERE username = '$username'";
      $run_check = mysqli_query($conn , $checkusername) or die(mysqli_error($conn));
      $countusername = mysqli_num_rows($run_check); 
      if ($countusername > 0 ) { ?>
      	<div class="isa_error">
             <i class="fa fa-times-circle"></i> <?php
  echo  "Username is already in use ! try a different one."; ?>
  </div>
  <?php
}
$email = $validated_data['email'];
$checkemail = "SELECT * FROM users WHERE email = '$email'";
      $run_check = mysqli_query($conn , $checkemail) or die(mysqli_error($conn));
      $countemail = mysqli_num_rows($run_check); 
      if ($countemail > 0 ) {
      	?>
      	<div class="isa_error">
             <i class="fa fa-times-circle"></i> <?php
  echo  "Email already in use ! try a different one"; ?>
  </div>
<?php
}

  else {
      $name = $validated_data['name'];
      $email = $validated_data['email'];
      $pass = $validated_data['password'];
      $password = password_hash("$pass" , PASSWORD_DEFAULT);
      $role = $_POST['role'];
      $course = $_POST['course'];
      $gender = $_POST['gender'];
      $joindate = date("F j, Y");
      $query = "INSERT INTO users(username,name,email,password,role,course,gender,joindate,token) VALUES ('$username' , '$name' , '$email', '$password' , '$role', '$course', '$gender' , '$joindate' , '' )";
      $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
      if (mysqli_affected_rows($conn) > 0) {
         ?>
      	<div class="isa_success">
             <i class="fa fa-check"></i> <?php
  echo  "Registration Successful !  click on 'Already Member' to login";
  if($gender=="Female")
    {
     $mysqli=new mysqli('localhost','root','','notes') or die(mysqli_error($mysqli));
     $result = $mysqli->query("UPDATE users SET image = 'women.png' WHERE email = '$email' ")or die($mysqli->error); 
    } 
   
    ?>
  </div>
<?php 
 mailing($email);
}
else {
  echo "<script>alert('Error Occured');</script>";
}
}
}
}
?>
<br>

  <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Sign Up </h2>

    <!-- Signup Form -->
    <form method="POST">
      
      <input type="text" id="login" class="fadeIn second" name="name" placeholder="Name" tabindex="1" value="<?php if(isset($_POST['signup'])) { echo $_POST['name']; } ?>">
      <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email"
      value="<?php if(isset($_POST['signup'])) { echo $_POST['email']; } ?>">
      <input type="text" id="login" class="fadeIn second" name="username" placeholder="Username" tabindex="2" value="<?php if(isset($_POST['signup'])) { echo $_POST['username']; } ?>">
      <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
      <input type="password" id="password" class="fadeIn third" name="repassword" placeholder="Confirm Password">
      <select class="fadeIn fourth" name="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            </select>
      <select class="fadeIn fourth" name="role">
            <option value="Teacher">Teacher</option>
            <option value="Student">Student</option>
            </select>
      <select class="fadeIn fourth" name="course">
            <option value="Computer Science">Computer Sc Engineering</option>
            <option value="Electrical">Electrical Engineering</option>
            <option value="Mechanical">Mechanical Engineering</option>
            </select>                  
      <input type="submit" class="fadeIn fourth" value="Sign Up" name="signup" tabindex="5">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="login.php">Already Member? </a>
    </div>

  </div>
</div>
 <?php   
        function  mailing($email)
          {
                             $url = $_SERVER['REQUEST_URI'];
                            $parts = explode('/',$url);
                            $dir = $_SERVER['SERVER_NAME'];
                            for ($i = 0; $i < count($parts) - 1; $i++) {
                             $dir .= $parts[$i] . "/";
                            }
                            require 'PHPMailer/PHPMailerAutoload.php';

                            $mail = new PHPMailer;

                            $mail->isSMTP();                            // Set mailer to use SMTP
                            $mail->Host = 'smtp.gmail.com';             // Specify main and backup SMTP servers
                            $mail->SMTPAuth = true;                     // Enable SMTP authentication
                            $mail->Username = 'ankitasingh3306@gmail.com';          // SMTP username
                            $mail->Password = 'iambacksinu'; // SMTP password
                            $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 587;
                                             

                            $mail->setFrom('ankitasingh3306@gmail.com', 'Purple Notes');
                            $mail->addReplyTo('sonupalak47@gmail.com', 'Purple Notes');
                            $mail->addAddress($email);

                            $mail->isHTML(true);  // Set email format to HTML

                            $bodyContent = 'http://' . $dir . 'login.php';
                            $message = file_get_contents('acc_success.html');
                            $message = str_replace('andros', $bodyContent, $message);
                            $mail->Subject = 'Purple Notes Account';
                            $mail->Body    = $message;
                            $mail->AltBody = $bodyContent;
                            $mail->send();
          }                  
 ?>
</body>

</html>
