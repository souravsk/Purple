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
      $error='';                 
      $query = "SELECT * FROM users WHERE username = '$login_session'" ; 
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
?>

<?php
if (isset($_POST['upload'])) {
require "../../../gump.class.php";
$gump = new GUMP();
$_POST = $gump->sanitize($_POST); 

$gump->validation_rules(array(
    'title'    => 'required|max_len,60|min_len,3',
    'description'   => 'required|max_len,150|min_len,3',
));
$gump->filter_rules(array(
    'title' => 'trim|sanitize_string',
    'description' => 'trim|sanitize_string',
    ));
$validated_data = $gump->run($_POST);

if($validated_data === false) { 
      $error = $gump->get_readable_errors(true); ?>
  <?php
    $file_title = $_POST['title'];
      $file_description = $_POST['description'];
}
else {
    $file_title = $validated_data['title'];
      $file_description = $validated_data['description'];
if (isset($_SESSION['id'])) {
        $file_uploader = $_SESSION['username'];
        $file_uploaded_to = $_SESSION['course'];
    }

    $file = $_FILES['file']['name'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $validExt = array ('pdf', 'txt', 'doc', 'docx', 'ppt' , 'zip', 'pptx', 'xls', 'xlsx');
    if (empty($file)) {
echo "<script>alert('Please, attach a file !');</script>";
    }
    else if ($_FILES['file']['size'] <= 0 || $_FILES['file']['size'] > 30720000 )
    {
		echo "<script>alert('Invalid file size !');</script>";
    }
    else if (!in_array($ext, $validExt)){
        echo "<script>alert('Invalid file type !');</script>";

    }
    else {
        $folder  = '../../allfiles/';
        $fileext = strtolower(pathinfo($file, PATHINFO_EXTENSION) );
        $notefile = rand(1000 , 1000000) .'.'.$fileext;
        if(move_uploaded_file($_FILES['file']['tmp_name'], $folder.$notefile)) {
            $query = "INSERT INTO uploads(file_name, file_description, file_type, file_uploader, file_uploaded_to, file) VALUES ('$file_title' , '$file_description' , '$fileext' , '$file_uploader' , '$file_uploaded_to' , '$notefile')";
            $result = mysqli_query($conn , $query) or die(mysqli_error($conn));
            if (mysqli_affected_rows($conn) > 0) {
                echo "<script> alert('Upload successful ! will be published after Admin approval.');
                window.location.href='upload.php';</script>";
            }
            else {
                "<script> alert('Error while uploading..try again');</script>";
            }
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
  <title>Users</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
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
                <img src="../../profilepics/<?php echo $profilepic; ?>" alt="image">
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
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-message-processing"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">New Upload</h6>
                  <p class="text-gray ellipsis mb-0">
                    New File Uploaded!
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
                <img src="../../profilepics/<?php echo $profilepic; ?>" alt="image">
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
          <li class="nav-item active">
            <a class="nav-link" href="../../pages/upload/upload.php">
              <span class="menu-title">Upload</span>
              <i class="mdi mdi-cloud-upload menu-icon"></i>
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
              <button class="btn btn-block btn-lg btn-gradient-primary mt-4" onclick="window.location.href='../../pages/edit profile/edit_profile.php?section=<?php echo $_SESSION['username']; ?>'"><i class="mdi mdi-pencil"></i>&nbsp;Edit Profile</button>
            
            </span>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Upload
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Upload</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notes</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Notes</h4>
                  <p class="card-description">
                    Upload notes <code>.info<center><?php echo $error; ?></center></code>
                  </p>
                  <form class="forms-sample" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputName1">Title</label>
                      <input type="text" name="title" class="form-control" id="exampleInputName1" placeholder="Eg : Php Tutorial" value = "<?php if(isset($_POST['upload'])) {
                      echo $file_title; } ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleTextarea1">Description</label>
                      <textarea class="form-control" name="description" id="exampleTextarea1" 
                      placeholder="Eg : Basic Tutorial File Includes basic Php Programming" rows="4" required><?php if(isset($_POST['upload'])) {
                     echo $file_description;  } ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" name="file" class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info" disabled placeholder="Upload File">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary" type="button">Browse</button>
                          </span>
                        </div>
                      </div>
                    
                    <button type="submit" class="btn btn-gradient-primary mr-2" name="upload">Upload</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
        </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2020 <a href="#">Sonu Pal</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">made with <i class="mdi mdi-heart text-danger"></i></span>
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
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/file-upload.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
