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
if (isset($_GET['name'])) {
    $user = mysqli_real_escape_string($conn , $_GET['name']);
    $query = "SELECT * FROM users WHERE username= '$user'";
    $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn)) ;
    if (mysqli_num_rows($run_query) > 0 ) {
        while ($row = mysqli_fetch_array($run_query)) {
    $name = $row['name'];
    $email = $row['email'];
    $course = $row['course'];
    $role = $row['role'];
    $bio = $row['about'];
    $image = $row['image'];
    $jdate = strtotime($row['joindate']);
    $joindate = date(('F d, Y '),$jdate);
    $gender = $row['gender'];
    $username = $row['username'];
}
}
else {
    $name = "N/A";
    $email = "N/A";
    $course = "N/A";
    $role = "N/A";
    $bio = "N/A";
    $gender = "N/A";
    $joindate = "N/A";
    $username = "N/A";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
    <title>Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../images/favicon.png" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body{
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
    </style>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container emp-profile">
            <form method="post" action="../edit profile/edit_profile.php?section=<?php echo $username; ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src="../../profilepics/<?php echo $image; ?>" alt="Profile_Pic"/ style="border-radius: 5px">
                            <div class="file btn btn-lg btn-primary">
                                <?php echo ucfirst($name); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?php echo ucfirst($name); ?>
                                    </h5>
                                    <h6>
                                        <?php echo strtoupper($role); ?>
                                    </h6>
                                    <p class="proile-rating">RANKINGS : <span>8/10</span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Bio</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>GENDER </p>
                            <a href="#"><?php echo $gender; ?></a><br/>
                            <p>ROLE </p>
                            <a href="#"><?php echo ucfirst($course); ?>,</a><br/>
                            <a href="#"><?php echo ucfirst($role); ?></a><br/>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>User Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $username; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucfirst($name) ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $email; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Join Date</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $joindate; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Department</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo ucfirst($course); ?></p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">  
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p><?php echo $bio; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>
<script type="text/javascript">

</script>
</body>
</html>

<?php } 
      else {
    header("location:../../index.php");
    } 
 ?>
