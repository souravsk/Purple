<?php include 'includes/connection.php';?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" type="image/png" href="./images/icon.png">
  <title>Forgot Password</title>
      <link rel="stylesheet" href="css/style.css"> 
      <link rel="stylesheet" href="css/style2.css">
</head>

<body>
      <?php
if (isset($_POST['recover'])) {
$email = mysqli_real_escape_string($conn , $_POST['email']);
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
$query = "SELECT email FROM users WHERE email = '$email'";
$run = mysqli_query($conn , $query) or die (mysqli_error($conn) );
if (mysqli_num_rows($run) > 0) {
	function generateRandomString($length = 5) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}
 
$token_tmp = generateRandomString();
$token = md5($token_tmp);
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

$bodyContent = 'http://' . $dir . 'verifytoken.php?token='.$token;
$message = file_get_contents('temp.html');
$message = str_replace('stark', $bodyContent, $message);
$mail->Subject = 'Purple Password Assistance';
$mail->Body    = $message;
$mail->AltBody = $bodyContent;

?>

<?php
		$query2 = "UPDATE users set token = '$token' WHERE email = '$email'";
		$run = mysqli_query($conn , $query2) or die(mysqli_error($conn));
		$count = mysqli_affected_rows($conn);
		if($mail->send() && ($count > 0)) {
			?>
	<div class="isa_success">
             <i class="fa fa-check"></i> 
             <?php
          		echo  "Password recovery link has been sent !"; 
          	  ?>
    </div>
	<?php
} else { ?>

        <div class="isa_error">
             <i class="fa fa-times-circle"></i> 
             <?php
          		echo  "Error in sending Message !"; 
          	  ?>
    </div>
             <?php
          		  
          	  ?>
    </div>
   <?php
}
}
else { ?>
	  <div class="isa_error">
             <i class="fa fa-times-circle"></i> 
             <?php
         		 echo  "Email does not found in any record !";
         	  ?>
    </div>
<?php
}
}
else { ?>
	  <div class="isa_error">
             <i class="fa fa-times-circle"></i> 
             <?php
                  echo  "Invalid email type !";
              ?>
    </div>
 <?php
}
}

	?>
  <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active" style="color: dimgrey"> Forgot Password </h2>

    <!-- Login Form -->
    <form method="POST">
      
      <input type="text" id="login" class="fadeIn second" name="email" placeholder="Email">
      <input type="submit" class="fadeIn fourth" value="Send" name="recover">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="login.php">Back to Login</a>
    </div>

  </div>
</div>
  
  

</body>

</html>
