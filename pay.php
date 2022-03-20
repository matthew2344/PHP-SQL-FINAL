<?php
include('security.php');
include('header.php');
?>



<section class="probootstrap-section">
    <div class="container">
       <div class="row probootstrap-gutter40">
       <?php
            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
            echo '<h2>' .$_SESSION['status']. '</h2>';
            unset($_SESSION['status']);
            }
            ?>
         <?php 
         $query = "SELECT * FROM transaction WHERE customer_id = $userid";
         $queryPen = "SELECT * FROM penalty WHERE customer_id = $userid";
         $query_run = mysqli_query($connection, $query);
         $queryPen_run = mysqli_query($connection,$queryPen);
         $totalAmount = 0;
         ?>
           <div class="col-md-8">
               <h2 class="mt0">Payment Chart</h2>
               <div class="row">
                 <div class="table-responsive">
                   <table class="table table-bordered" id="dataTable" width="100" cellspacing="0" cellpadding="0">
                      <tr>
                        <td>Description</td>
                        <td>Cost</td>
                      </tr>
                      <?php
            if(mysqli_num_rows($query_run) > 0)        
            {
                while($row = mysqli_fetch_assoc($query_run))
                {
          ?>
                      <tr>
                        <td>Booked a Room</td>
                        <td>$<?php echo $row['amount_pay'];?></td>
                      </tr>
                      <?php
                      $totalAmount = $totalAmount + $row['amount_pay'];
                } 
            }
            else {
            echo "No Record Found";
            }
          ?>
          <?php
            if(mysqli_num_rows($queryPen_run) > 0)        
            {
                while($row = mysqli_fetch_assoc($queryPen_run))
                {
          ?>
                  <tr>
                    <td>Penalty of Room Cancellation</td>
                    <td>$<?php echo $row['amount'];?></td>
                  </tr>
                  <?php
                  $totalAmount = $totalAmount + $row['amount'];
                } 
            }
            else {
            echo "No Record Found";
            }
          ?>        

          <tr>
            <td>Total Amount</td>
            <td>$<?php echo $totalAmount;?></td>
          </tr>

                   </table>
                 </div>
               </div>             
           </div>


            <div class="col-md-4">
                <h2 class="mt0">About</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                <form action="" method="POST">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-lg" id="submit"  data-toggle="modal" data-target="#a">
                            Pay Balance
                        </button>
                    </div>
                </form>
            </div>

        </div>
        
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="a" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment <i class="bi bi-credit-card-2-back-fill"></i></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form action="code.php" method="POST">
        <div class="modal-body">
                <div class="form-group">
                    <label>Total Amount to Pay: $<?php echo $totalAmount; ?></label>
                    <input type="hidden" name="balance" value="<?php echo $totalAmount ?>">
                </div>
                <div class="form-group">
                    <label>Enter Payment</label>
                    <input type="text" name="paymentInput" class="form-control" placeholder="Enter payment" required>
                </div> 
        </div>
        <div class="modal-footer">
            <input type="hidden" name="userid" value="<?php echo $userid ?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="paymentsubmit" class="btn btn-primary">Enter Payment</button>
        </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal -->














<?php include('footer.php')?>