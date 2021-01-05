<?php 
include ("../includes/connection.php");
include ("../includes/config.php");
if (isset($_SESSION['role'])) {
    
}
else {
    echo "<script>alert('Please Login First !');
    window.location.href='../login.php';</script>"; 
}
?>
<?php                   
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
        $dept = $row['course'];
        $bio = $row['about'];
  }
?>                     
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php"><img src="images/logo.svg" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/logo-mini.svg" alt="logo"/></a>
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
                <img src="profilepics/<?php echo $profilepic; ?>" alt="image">
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black"><?php echo ucfirst($name); ?> </p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="../logout.php">
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
            <a class="nav-link" href="../logout.php">
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
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              <div class="nav-profile-image">
                <img src="profilepics/<?php echo $profilepic; ?>" size=300x500 alt="Profile">
                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
              </div>
              <div class="nav-profile-text d-flex flex-column">
                <span class="font-weight-bold mb-2"><?php echo ucfirst($name); ?></span>
                <span class="text-secondary text-small"><?php echo strtoupper($_SESSION['role']); ?></span>
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="index.php">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/upload/upload.php">
              <span class="menu-title">Upload</span>
              <i class="mdi mdi-cloud-upload menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./pages/notes/notes.php">
              <span class="menu-title">Notes</span>
              <i class="mdi mdi-book-open-page-variant menu-icon"></i>
            </a>
          </li>
            <li class="nav-item">
            <a class="nav-link" href="./pages/Profile/profile.php?name=<?php echo $_SESSION['username']; ?>">
              <span class="menu-title">Profile</span>
              <i class="mdi mdi-face menu-icon"></i>
            </a>
          </li>
          <li class="nav-item sidebar-actions">
            <span class="nav-link">
              <div class="border-bottom">              
              </div>
              <button class="btn btn-block btn-lg btn-gradient-primary mt-4" onclick="window.location.href='./pages/edit profile/edit_profile.php?section=<?php echo $_SESSION['username']; ?>'"><i class="mdi mdi-pencil"></i>&nbsp;Edit Profile</button>
            
            </span>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>
          <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3">Total Uploads
                    <i class="mdi mdi-debug-step-out mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5">
                    <?php
                     $mysqli=new mysqli('localhost','root','','notes') or die(mysqli_error($mysqli));
                     $result = $mysqli->query("SELECT * FROM uploads WHERE file_uploaded_to='$dept'" )or die($mysqli->error);
                     $dcount = $result->num_rows; 
                     $result = $mysqli->query("SELECT * FROM users WHERE course='$dept'")or die($mysqli->error);
                     $ucount = $result->num_rows; 
                     $result = $mysqli->query("SELECT * FROM users WHERE course='$dept' AND role='teacher'")or die($mysqli->error);
                     $tcount = $result->num_rows; 
                     ?>
                    <?php echo $dcount ?></h2>
                  <h6 class="card-text">Increased by 20%</h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                  
                  <h4 class="font-weight-normal mb-3">Teachers Online
                    <i class="mdi mdi-account-star mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"><?php echo $tcount ?></h2>
                  <h6 class="card-text">Increased by 15%</h6>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image"/>                                    
                  <h4 class="font-weight-normal mb-3">Visitors Online
                    <i class="mdi mdi-account-multiple mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5"><?php echo $ucount ?></h2>
                  <h6 class="card-text">Increased by 10%</h6>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="clearfix">
                    <h4 class="card-title float-left">Upload Statistics</h4>
                    <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>                                     
                  </div>
                  <canvas id="visit-sale-chart" class="mt-4"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Users Statistics</h4>
                  <canvas id="traffic-chart"></canvas>
                  <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>                                                      
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Recent Uploads</h4>
                  <div class="table-responsive">
                    <?php
    
                    $mysqli=new mysqli('localhost','root','','notes') or die(mysqli_error($mysqli));
                    $result=$mysqli->query("SELECT * FROM uploads WHERE file_uploaded_to='$dept' AND status='approved'")or die($mysqli->error);
                    if (mysqli_num_rows($result) > 0) {
                       // output data of each row
                    ?>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>
                            Name
                          </th>
                          <th>
                            Description
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Last Update
                          </th>
                          <th>
                            File Type
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                             $cnt = 0;
                             while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        
                        <tr>
                          <td>
                            <?php  echo ucwords($row['file_uploader']);?>
                          </td>
                          <td>
                            <?php  echo ucwords($row['file_name']); ?>
                          </td>
                          <td>
                            <label class="badge badge-gradient-<?php 
                                                                 if($row['status']=='approved')
                                                                   {
                                                                    echo "success";
                                                                    $status="APPROVED";
                                                                   }
                                                                 else
                                                                 {
                                                                     echo "info";
                                                                     $status="ON HOLD";
                                                                 }  
                                                                ?>"><?php  echo $status; ?> 
                          </label>
                          </td>
                          <td>
                           <?php  $file_date=strtotime($row['file_uploaded_on']);
                                  $date = date(('F d, Y '),$file_date);
                                  echo $date; ?>
                          </td>
                          <td>
                            <?php
                            $file_type = $row['file_type'];
                              switch ($file_type) {
                                case 'pdf': ?>
                                  <i class="mdi mdi-file-pdf-box mdi-24px" style="color:#f92424;">&nbsp</i>
                              <?php    break;
                                case 'txt': ?>
                                  <i class="mdi mdi-clipboard-text mdi-24px" style="color:#b66dff">&nbsp</i>
                              <?php    break;
                                case 'zip': ?>
                                  <i class="mdi mdi-zip-box mdi-24px" style="color:#fed713ed;">&nbsp</i>  
                              <?php    break;
                                case 'doc': ?>
                                <i class="mdi mdi-file-document-box mdi-24px" style="color:#007bffba;">&nbsp</i>
                              <?php    break;
                                case 'docx':?>
                                <i class="mdi mdi-file-document-box mdi-24px" style="color:#007bffba;">&nbsp</i>
                              <?php    break;
                                case 'pptx':?>
                                 <i class="mdi mdi-file-powerpoint-box mdi-24px" style="color:#ff7e33f2;">&nbsp</i>
                              <?php    break;
                                case 'ppt' :?>
                                 <i class="mdi mdi-file-powerpoint-box mdi-24px" style="color:#ff7e33f2;">&nbsp</i>
                                <?php  break;
                                case 'xlsx':?>
                                 <i class="mdi mdi-file-excel-box mdi-24px" style="color:#28a745d6;">&nbsp</i>
                                <?php break;
                                case 'xls':?>
                                 <i class="mdi mdi-file-excel-box mdi-24px" style="color:#28a745d6;">&nbsp</i>
                                <?php break;
                                default: ?>
                                  <i class="mdi mdi-file mdi-24px" style="color:#6c757dc2;">&nbsp</i>
                                <?php break;
                              }

                            ?>
                            <?php  echo strtoupper($file_type); ?>
                          </td>
                        </tr>
                        <tr>
                          <?php 
                                                 if($cnt==4){
                                                     break;
                                                 }
                                                     
                                                $cnt++;
                              }
                              ?>      
                      </tbody>
                    </table>
                    <?php     
                              }
                           else {
                              echo "0 results";
                       }
                            ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
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
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.php"></script>
  <!-- End custom js for this page-->
</body>

</html>
