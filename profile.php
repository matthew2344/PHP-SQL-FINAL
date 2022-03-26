<?php
include('security.php');
include('header.php');
?>

<!-- Modal Password-->
<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="modal" data-target="#editInfo">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="code.php" method="POST">
        <div class="modal-body">
                <div class="form-group">
                    <label>Old Password</label>
                    <input type="password" name="Oldpassword" class="form-control"  placeholder="Enter Old Password" required>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="Newpassword" class="form-control" placeholder="Enter New Password" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm New Password" required>
                </div>    
        </div>
        <div class="modal-footer">
            <input type="hidden" name="updateid" value="<?php echo $userid ?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#editInfo">Close</button>
            <button type="submit" name="SaveNewPass" class="btn btn-primary">Save changes</button>
        </div>
        </form>
    </div>
  </div>
</div>
<!-- Modal Password-->


<!-- Modal Common Info-->
<div class="modal fade" id="editInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php
      $query = "SELECT * FROM customer WHERE id = '$userid'";
      $query_run = mysqli_query($connection, $query);
            ?>
      <form action="code.php" method="POST">
        <?php 
        foreach($query_run as $row)
        {
        ?>
        <div class="modal-body">

            <div class="form-group">
                <label> First Name </label>
                <input type="text" name="fname" class="form-control" value="<?php echo $row['fname']?>" placeholder="Change First Name">
            </div>
            <div class="form-group">
                <label> Last Name </label>
                <input type="text" name="lname" class="form-control" value="<?php echo $row['lname']?>" placeholder="Change Last Name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $row['email']?>" placeholder="Change Email">
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#changePass" data-dismiss="modal">
                Change Password 
                </button>
            </div>

        </div>
        <div class="modal-footer">
            <input type="hidden" name="updateid" value="<?php echo $userid ?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="ChangeInfoBtn" class="btn btn-primary">Save</button>
        </div>
      </form>
      <?php 
        }
      ?>
    </div>
  </div>
</div>
<!-- Modal Common Info-->


<?php
      $query = "SELECT * FROM customer WHERE id = '$userid'";
      $query_run = mysqli_query($connection, $query);
      foreach($query_run as $row)
      {
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
      }

?>



<section class="probootstrap-section">

    <div class="container">
            <?php
            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
            echo '<h2>' .$_SESSION['status']. '</h2>';
            unset($_SESSION['status']);
            }

            if(isset($_SESSION['status_common']) && $_SESSION['status_common'] !='')
            {
            echo '<h2 class="bg-info">' .$_SESSION['status_common']. '</h2>';
            unset($_SESSION['status_common']);
            }
            
            if(isset($_SESSION['status_password']) && $_SESSION['status_password'] !='')
            {
            echo '<h2 class="bg-info">' .$_SESSION['status_password']. '</h2>';
            unset($_SESSION['status_password']);
            }
        ?>
        <div class="row">
            <div class="col-md-12">
                <h1>Profile</h1>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editInfo">
                Change Profile 
                </button>
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <td colspan="5">Dashboard</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                          <td>First Name:</td>
                          <td colspan="5"><?php echo "$fname"; ?></td>
                        </tr>
                        <tr>
                          <td>Last Name:</td>
                          <td colspan="5"><?php echo "$lname"; ?></td>
                        </tr>
                        <tr>
                          <td>Email:</td>
                          <td colspan="5"><?php echo "$email"; ?></td>
                        </tr>
                    </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    


</section>







<?php include('footer.php')?>