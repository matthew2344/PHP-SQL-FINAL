<!DOCTYPE html>
<?php 
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[2];

$customer = "customer";
$email = $_SESSION['cusername'];
$connection = mysqli_connect("localhost","root","","test");
$get_user = "SELECT * FROM $customer WHERE email='$email'";
$get_user_run = mysqli_query($connection, $get_user);
foreach($get_user_run as $user){
  $userid = $user['id'];
  $fname = $user['fname'];
  $lname = $user['lname'];
  $email = $user['email'];
}
?>
<?php 
  $mindate = date("Y-m-d");
  $mintime = date("h:i");
  $date_limit =  new DateTime($mindate);
  $date_limit->add(new DateInterval('P2D'));
  $date = $date_limit->format('Y-m-d');
  $min = $date."T".$mintime;
  
  
  $date_limit2 =  new DateTime($mindate);
  $date_limit2->add(new DateInterval('P3D'));
  $date2 = $date_limit2->format('Y-m-d');
  $min2 = $date2."T".$mintime;

  // $query = "SELECT * FROM reservation WHERE customer_id = '$userid'";
  // $query_run = mysqli_query($connection, $get_user);
  // $today_date = date('Y-m-d H:i:s');
  // foreach($query_run as $row){
  //   $get_end = date('Y-m-d H:i:s',strtotime($select_row['date_end']));
  // }
  
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>uiCookies:Atlantis &mdash; Free Bootstrap Theme, Free Responsive Bootstrap Website Template</title>
    <meta name="description" content="Free Bootstrap Theme by uicookies.com">
    <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
    
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:300,400,700|Rubik:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="css/styles-merged.css">
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!--[if lt IE 9]>
      <script src="js/vendor/html5shiv.min.js"></script>
      <script src="js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <!-- START: header -->

  <header role="banner" class="probootstrap-header">
    <!-- <div class="container"> -->
    <div class="row">
        <a href="index.html" class="probootstrap-logo visible-xs"><img src="img/logo_sm.png" class="hires" width="120" height="33" alt="Free Bootstrap Template by uicookies.com"></a>
        
        <a href="#" class="probootstrap-burger-menu visible-xs"><i>Menu</i></a>
        <div class="mobile-menu-overlay"></div>

        <nav role="navigation" class="probootstrap-nav hidden-xs">
          <ul class="probootstrap-main-nav">
            <li class="<?php if ($first_part == "index.php") {echo "active";} else {echo "noactive";}?>"><a href="index.php">Home</a></li>
            <li class="<?php if ($first_part == "about.html") {echo "active";} else {echo "noactive";}?>"><a href="about.html">About</a></li>
            <li class="<?php if ($first_part == "rooms.php") {echo "active";} else {echo "noactive";}?>"><a href="rooms.php">Our Rooms</a></li>
            <li class="hidden-xs probootstrap-logo-center">
              <a href="index.php"><img src="img/logo_md.png" class="hires" width="181" height="50" alt="Free Bootstrap Template by uicookies.com"></a>
            </li>
            <li class="<?php if ($first_part == "reservation.php") {echo "active";} else {echo "noactive";}?>"><a href="reservation.php">Reservation</a></li>
            <li class="<?php if ($first_part == "blog.html") {echo "active";} else {echo "noactive";}?>"><a href="blog.html">Blog</a></li>
            <li class="<?php if ($first_part == "contact.html") {echo "active";} else {echo "noactive";}?>"><a href="contact.html">Contact</a></li>
            <li class="visible-xs"><a href="contact.html">
              <span>
                <?php echo $_SESSION['cusername'];?></a>
              </span>
              
            </li>
            <li class="nav-item dropdown no-arrow ms-auto hidden-xs">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    
                    <?php echo $_SESSION['cusername'];?>
                    
                    </span>
                </a>
                 <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in hidden-xs" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="book.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  My Reservation
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
          <div class="extra-text visible-xs">
            <a href="#" class="probootstrap-burger-menu"><i>Menu</i></a>
            <h5>Connect With Us</h5>
            <ul class="social-buttons">
              <li><a href="#"><i class="icon-twitter"></i></a></li>
              <li><a href="#"><i class="icon-facebook2"></i></a></li>
              <li><a href="#"><i class="icon-instagram2"></i></a></li>
            </ul>
            
          </div>
        </nav>
        </div>
    <!-- </div> -->

    
      <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

          <form action="logout.php" method="POST"> 
          
            <button type="submit" name="logout_btn_customer" class="btn btn-primary">Logout</button>

          </form>


        </div>
      </div>
    </div>
  </div>
  </header>
  <!-- END: header -->