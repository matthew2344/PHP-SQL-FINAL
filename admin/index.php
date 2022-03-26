<?php
include('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
$user= "admins";
?>


<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Total Admin Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Registered Admin</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">

              <?php
                $query = "SELECT id FROM $user ORDER BY id";  
                $query_run = mysqli_query($connection, $query);
                $row = mysqli_num_rows($query_run);
                echo '<h4> Total Admin: '.$row.'</h4>';
              ?>

              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <?php
              $query = "SELECT SUM(amount) FROM invoice";
              $query_run = mysqli_query($connection,$query);
              if($query_run)
              {
                $row = mysqli_fetch_assoc($query_run);
                $amount = $row['SUM(amount)'];
              }
              else
              {
                $amount = 0;
              }

              ?>
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings of Company</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo $amount; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Total Reservation Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <?php 
              $query = "SELECT COUNT(*) FROM reservation";
              $query_run = mysqli_query($connection, $query);
              if($query_run)
              {
                $res = mysqli_fetch_assoc($query_run);
                $resnum = $res['COUNT(*)'];
              }
              else
              {
                $resnum = 0;
              }
            ?>
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Reservation</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Count: <?php echo $resnum; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-door-open fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


  <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
            <?php 
              $query = "SELECT COUNT(*) FROM customer";
              $query_run = mysqli_query($connection, $query);
              if($query_run)
              {
                $cus = mysqli_fetch_assoc($query_run);
                $cusnum = $cus['COUNT(*)'];
              }
              else
              {
                $cusnum = 0;
              }
            ?>
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Customer Count</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">Total: <?php echo $cusnum; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row -->








<?php
include('includes/scripts.php');
include('includes/footer.php');
?>