<?php 
include ("../../../includes/connection.php");
include ("../../../includes/config.php");
if (isset($_SESSION['role'])) {
  
}
else {
    echo "<script>alert('Please Login First !');
    window.location.href='../../../login.php';</script>"; 
}
?>

<?php
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $query = "SELECT * FROM users WHERE username = '$username'" ; 
  $result= mysqli_query($conn , $query) or die (mysqli_error($conn));
  if (mysqli_num_rows($result) > 0 ) {
    $row = mysqli_fetch_array($result);
    $userid = $row['id'];
    $usernm = $row['username'];
    $userpassword = $row['password'];
    $useremail = $row['email'];
    $name = $row['name'];
    $profilepic = $row['image'];
    $bio = $row['about'];

  }

if (isset($_POST['update'])) {
$image = $_FILES['image']['name'];
    $ext = $_FILES['image']['type'];
    $validExt = array ("image/gif",  "image/jpeg",  "image/pjpeg", "image/png");
    if (empty($image)) {
      $picture = $profilepic;
    }
    else if ($_FILES['image']['size'] <= 0 || $_FILES['image']['size'] > 1024000 )
    {
echo "<script>alert('Image size is not proper');
 window.location.href='edit_profile.php';</script>";
 }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Not a valid image');
        window.location.href='edit_profile.php';</script>";
    }
    else {
        $folder  = '../../../UDashboard/profilepics/';
        $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION) );
        $picture = rand(1000 , 1000000) .'.'.$imgext;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $folder.$picture)) {
        $queryupdate = "UPDATE users SET image = '$picture' WHERE id= '$userid' " ;
        $result = mysqli_query($conn , $queryupdate) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
          echo "<script>alert('Profile Updated Successfully !');
          window.location.href= 'edit_profile.php';</script>";
        }
        else {
          echo "<script>alert('Error ! ..try again');</script>";
}
}
else {
  echo "<script>alert('Error occured while uploading! ..try again');</script>";
}
}
}
else  {
  $picture = $row['image'];
}


if (isset($_POST['update'])) {
require "../../../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 


$gump->validation_rules(array(
  'name'   => 'required|alpha_space|max_len,30|min_len,2',
  'email'       => 'required|valid_email',
    'bio'    => 'max_len,150',
  'currentpassword' => 'required|max_len,50|min_len,6',
  'newpassword'    => 'max_len,50|min_len,6',
));
$gump->filter_rules(array(
  'name' => 'trim|sanitize_string',
  'currentpassword' => 'trim',
  'newpassword' => 'trim',
  'email'    => 'trim|sanitize_email',
  'bio' => 'trim',
  ));
$validated_data = $gump->run($_POST);
if($validated_data === false) {
  echo "<script>alert($gump->get_readable_errors(true));
  window.location.href='edit_profile.php';</script>";
}

else if (!password_verify($validated_data['currentpassword'] ,  $userpassword))   
{
  echo  "<script>alert(Current password is incorrect!);
  window.location.href='edit_profile.php';</script>";

}
else if (empty($_POST['newpassword'])) {
  $name = $validated_data['name'];
      $useremail = $validated_data['email'];
      $userbio = $validated_data['bio'];
      $updatequery1 = "UPDATE users SET name = '$name' , email='$useremail' , about='$userbio' WHERE id = '$userid' " ;
      $result2 = mysqli_query($conn , $updatequery1) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
  echo "<script>alert('Profile Updated Successfully');
    window.location.href='edit_profile.php';</script>";
}
else {
  echo "<script>alert('No new details, Please submit new details!');</script>";
}
}
else if (isset($_POST['newpassword']) &&  ($_POST['newpassword'] !== $_POST['confirmnewpassword'])) 
{
  echo  "<script>alert(New password and Confirm New password do not match);
   window.location.href='edit_profile.php';</script>";
  
}
else {
      $name = $validated_data['name'];
      $useremail = $validated_data['email'];
      $pass = $validated_data['newpassword'];
      $userpassword = password_hash("$pass" , PASSWORD_DEFAULT);

$updatequery = "UPDATE users SET password = '$userpassword', name='$name', email= '$useremail' WHERE id='$userid'";
$result1 = mysqli_query($conn , $updatequery) or die(mysqli_error($conn));
if (mysqli_affected_rows($conn) > 0) {
  echo "<script>alert('Profile Updated Successfully');
  window.location.href='edit_profile.php';</script>";
}
else {
  echo "<script>alert('An error occured, Try again !');</script>";
}
}
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Profile</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />
    
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="../../index.php"><img src="../../images/logo.svg" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="../../index.php"><img src="../../images/logo-mini.svg" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <div class="search-field d-none d-md-block">
          <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>                
              </div>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Search">
            </div>
          </form>
        </div>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="../../../UDashboard/profilepics/<?php echo $profilepic; ?>" alt="image">
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo ucfirst($name); ?> </p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="../../../logout.php">
                <i class="mdi mdi-logout mr-2 text-primary"></i>
                Signout 

              </a>
            </div>
          </li>
          <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li>
          <li class="nav-item dropdown">
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count-symbol bg-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0">Notifications</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <?php if($bio=='N/A' || $bio=="")
                            {
                              $ann="Announcement";
                              $notifiy="Update Bio !";
                              $nicon="mdi mdi-bullhorn";
                            }
                          else
                            {
                              $ann="All Set.";
                              $notifiy="No Notications.";
                              $nicon="mdi mdi-check";
                            } 
                     ?>
                    <i class="<?php echo $nicon; ?>"></i>
                  </div>
                </div> 
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1"><?php echo $ann; ?></h6>
                  <p class="text-gray ellipsis mb-0"> 
                    <?php echo $notifiy; ?>       
                  </p>
                </div>
              </a>
              </div>
          </li>
          <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="../../../logout.php">
              <i class="mdi mdi-power"></i>
            </a>
          </li>
          <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-format-line-spacing"></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="../../../UDashboard/profilepics/<?php echo $profilepic; ?>" alt="profile">
                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2"><?php echo ucfirst($name); ?></span>
                <span class="text-secondary text-small"><?php echo strtoupper($_SESSION['role']); ?></span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/users/users.php">
              <span class="menu-title">Users</span>
              <i class="mdi mdi mdi-account-multiple menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/notes/notes.php">
              <span class="menu-title">Notes</span>
              <i class="mdi mdi-book-open-page-variant menu-icon"></i>
            </a>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="../../pages/Profile/profile.php?name=<?php echo $_SESSION['username']; ?>">
              <span class="menu-title">Profile</span>
              <i class="mdi mdi-face menu-icon"></i>
            </a>
          </li>
          <li class="nav-item sidebar-actions">
            <span class="nav-link">
              <div class="border-bottom">              
              </div>
              <button class="btn btn-block btn-lg btn-gradient-primary mt-4"  onclick="window.location.href='../../pages/edit profile/edit_profile.php?section=<?php echo $_SESSION['username']; ?>'"><i class="mdi mdi-pencil"></i>&nbsp;Edit Profile</button>
            
            </span>
          </li>
        </ul>
      </nav>
      <!-- partial -->
          <div class="main-panel">        
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Profile
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">User elements</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin ">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Profile</h4>
                  <p class="card-description">
                    <?php echo ucfirst($name); ?>
                  </p>
                  <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputUsername1">Username</label>
                      <input type="text" class="form-control" id="exampleInputUsername1" value="<?php echo $username; ?>"readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" value="<?php echo $useremail; ?>"readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">New Password </label>
                      <input type="password" name="newpassword"class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputConfirmPassword1">Confirm Password</label>
                      <input type="password" name="confirmnewpassword" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label>Profile Pic</label>
                      <input type="file" name="image" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-gradient-primary" type="submit" name="uploadphoto">Browse</button>
                        </span>
                      </div>
                    </div>
                  
                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Profile Verification</h4>
                  <p class="card-description">
                    Confirm Details
                  </p>
                 
                    <div class="form-group row">
                      <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="exampleInputUsername2" value="<?php echo $name; ?>" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputEmail2" class="col-sm-3 col-form-label"> New Email</label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control" id="exampleInputEmail2" name="email" 
                        value="<?php echo $useremail; ?>" placeholder="Email" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputMobile" class="col-sm-3 col-form-label">Bio</label>
                      <div class="col-sm-9">
                        <textarea class="form-control" name="bio" id="exampleTextarea1" rows="4"><?php  echo $bio; ?>
                        </textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Current Password</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="exampleInputPassword2" name="currentpassword" placeholder="Current Password" required>
                      </div>
                    </div>
                    <button type="submit" name="update"class="btn btn-gradient-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="https://www.bootstrapdash.com/" target="_blank">Sonu Pal</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <script src="../../vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
