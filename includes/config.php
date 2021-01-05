<?php
   include('connection.php');
   session_start();
 $user_check = $_SESSION['username'];
   
   
   $ses_sql = mysqli_query($conn,"select username from users where username = '$user_check' ");
   $ses_sqli = mysqli_query($conn,"select role from users where username = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $row1 = mysqli_fetch_array($ses_sqli,MYSQLI_ASSOC);

   
   $login_session = $row['username'];
   $login_type = $row1['role'];

   ?>