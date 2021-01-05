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
        $dept= $row['course'];
        $bio = $row['about'];
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Notes</title>
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
                <img src="../../profilepics/<?php echo $profilepic; ?>" size=300x500 alt="Profile">
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
            <a class="nav-link" href="../../pages/upload/upload.php">
              <span class="menu-title">Upload</span>
              <i class="mdi mdi-cloud-upload menu-icon"></i>
            </a>
          </li>
          <li class="nav-item active">
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
              All Notes
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Notes</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Notes</h4>
                  <p class="card-description">
                    Check notes <code>.info</code>
                  </p>
                  <div class="table-responsive">
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
                            Upload Date
                          </th>
                          <th>
                            Uploader
                          </th>
                          <th>
                            File Type
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            View
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                              $query = "SELECT * FROM uploads WHERE file_uploaded_to='$dept' AND status='approved' ORDER BY file_uploaded_on DESC";
                              $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                              if (mysqli_num_rows($run_query) > 0) {
                              while ($row = mysqli_fetch_array($run_query)) {
                                  $file_id = $row['file_id'];
                                  $file_name = $row['file_name'];
                                  $file_description = $row['file_description'];
                                  $file_type = $row['file_type'];
                                  $file_date = strtotime($row['file_uploaded_on']);
                                  $date = date(('F d, Y '),$file_date);
                                  $file_uploader = $row['file_uploader'];
                                  $file_status = $row['status'];
                                  $file = $row['file']; ?>
                        <tr>
                          <td>
                           <?php echo ucfirst($file_name); ?>
                          </td>
                          <td>
                            <?php echo ucfirst($file_description); ?>
                          </td>
                          <td>
                            <?php echo $date; ?>
                          </td>
                          <td>
                            <?php echo ucfirst($file_uploader); ?>
                          </td>
                          <td>
                             <?php
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
                          </label>
                          </td>
                          <td>
                           <label class="badge badge-gradient-<?php 
                                                                 if($file_status=='approved')
                                                                   {
                                                                    echo "success";
                                                                    $file_status="APPROVED";
                                                                   }
                                                                 else
                                                                 {
                                                                     echo "info";
                                                                     $file_status="ON HOLD";
                                                                 }  
                                                                ?>"><?php  echo $file_status; ?> 
                          </td>
                          <td>
                            <button type="button" class="btn btn-inverse-primary btn-rounded btn-icon"
                            onclick="window.location.href='../../allfiles/<?php echo $file; ?>'">
                             <i class="mdi mdi-cloud-download mdi-24px"></i>
                           </button>
                          </td>
                        </tr><?php
                      }
                    }
                    ?>
                      </tbody>
                    </table>
                </div>

              </div>
            </div>
          </div>
        </div>
         <div class="page-header">
            <h3 class="page-title"> 
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Notes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Approved notes</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">My Notes</h4>
                  <p class="card-description">
                    Delete notes <code>.info</code>
                  </p>
                  <div class="table-responsive">
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
                            Upload Date
                          </th>
                          <th>
                            File Type
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            View
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                              $query = "SELECT * FROM uploads WHERE file_uploaded_to='$dept' AND file_uploader='$usernm' ORDER BY file_uploaded_on DESC";
                              $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
                              if (mysqli_num_rows($run_query) > 0) {
                              while ($row = mysqli_fetch_array($run_query)) {
                                  $file_id = $row['file_id'];
                                  $file_name = $row['file_name'];
                                  $file_description = $row['file_description'];
                                  $file_type = $row['file_type'];
                                  $file_date = strtotime($row['file_uploaded_on']);
                                  $date = date(('F d, Y '),$file_date);
                                  $file_uploader = $row['file_uploader'];
                                  $file_status = $row['status'];
                                  $file = $row['file']; ?>
                        <tr>
                          <td>
                            <?php echo ucfirst($file_name); ?>
                          </td>
                          <td>
                            <?php echo ucfirst($file_description); ?>
                          </td>
                          <td>
                            <?php echo $date; ?>
                          </td>
                          <td>
                            <?php
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
                          <td>
                            <label class="badge badge-gradient-<?php 
                                                                 if($file_status=='approved')
                                                                   {
                                                                    echo "success";
                                                                    $file_status="APPROVED";
                                                                   }
                                                                 else
                                                                 {
                                                                     echo "info";
                                                                     $file_status="ON HOLD";
                                                                 }  
                                                                ?>"><?php  echo $file_status; ?> 
                          </label>
                          </td>
                          <td>
                            <button type="button" class="btn btn-inverse-primary btn-rounded btn-icon"
                            onclick="window.location.href='../../allfiles/<?php echo $file; ?>'">
                             <i class="mdi mdi-cloud-download mdi-24px"></i>
                            </button>
                          </td>
                          <td>
                            <a onClick="javascript: return confirm('Are you sure to delete <?php echo $file; ?> ?')" href='?del=<?php echo $file_id; ?>'>
                            <button type="button" class="btn btn-inverse-danger btn-rounded btn-icon">
                             <i class="mdi mdi-delete mdi-24px"></i>
                           </button>
                             </a>
                         </td>
                        </tr>
                        <?php
                         }
                       }
                       ?>
                      </tbody>
                    </table>
                </div>
 <?php
 
    if (isset($_GET['del'])) {
        $note_del = mysqli_real_escape_string($conn, $_GET['del']);
        $file_uploader = $_SESSION['username'];
        $del_query = "DELETE FROM uploads WHERE file_id='$note_del'";
        $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('Note Deleted successfully !');
            window.location.href='notes.php';</script>";
        }
        else {
         echo "<script>alert('error occured.try again!');</script>";   
        }
        }

         if (isset($_GET['approve'])) {
        $note_approve = mysqli_real_escape_string($conn,$_GET['approve']);
        $approve_query = "UPDATE uploads SET status='approved' WHERE file_id='$note_approve'";
        $run_approve_query = mysqli_query($conn, $approve_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('Note Approved Successfully !');
            window.location.href='notes.php';</script>";
        }
        else {
         echo "<script>alert('Note already Approved !');</script>";   
        }
        }
       

?>
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
  <!-- End custom js for this page-->   
</body>

</html>
