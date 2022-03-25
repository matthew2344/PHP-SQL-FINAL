<?php
$roomdb = "room";
include('security.php');
include('header.php');
?>


<section class="probootstrap-slider flexslider probootstrap-inner">
    <ul class="slides">
       <li style="background-image: url(img/slider_1.jpg);" class="overlay">
          <div class="container">
            <div class="row">
              <div class="col-md-10 col-md-offset-1">
                <div class="probootstrap-slider-text text-center">
                  <p><img src="img/curve_white.svg" class="seperator probootstrap-animate" alt="Free HTML5 Bootstrap Template"></p>
                  <h1 class="probootstrap-heading probootstrap-animate">Book A Room</h1>
                  <div class="probootstrap-animate probootstrap-sub-wrap">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</div>
                </div>
              </div>
            </div>
          </div>
        </li>
    </ul>
  </section>
  
  <section class="probootstrap-section">
  <?php


      $roomID = $_SESSION['roomID'];
      $roomstart = $_SESSION['date_start'];
      $roomend = $_SESSION['date_end'];
      $amount = $_SESSION['amount'];

      

      
      $ad = "SELECT * FROM room WHERE id = '$roomID'";
      $a_run = mysqli_query($connection, $ad);

      $a = mysqli_fetch_assoc($a_run);
      $roomType = $a['type'];
      $roomTitle = $a['title'];


      

      $query = "SELECT * FROM room_number 
      WHERE room_number.id NOT IN (SELECT room_number FROM room_reserved) 
      AND room_number.room_id = '$roomID'";
      $query_run = mysqli_query($connection, $query);
    ?>
    <div class="container">
      <?php 
      if(isset($_SESSION['ERROR']) && $_SESSION['ERROR'] !='')
      {
        echo '<h2 class="bg-info">' .$_SESSION['ERROR']. '</h2>';
        unset($_SESSION['ERROR']);
      }
      ?>
      <div class="row probootstrap-gutter40">
        <div class="col-md-8">
          <h1 class="mt0">Room Type: <?php echo $roomTitle; ?></h1>
          <h2 class="mt0">Select Room Form</h2>
          <form action="code.php" method="post" class="probootstrap-form">
            <div class="form-group">
              <label for="room">Room <small style="color: red;">* Choose Room Number</small></label>
              <div class="form-field">
                <i class="icon icon-chevron-down"></i>
                <select name="room" id="room" class="form-control" required>
                  <option value="">Select a Room Number</option>
                  <?php 
                    if(mysqli_num_rows($query_run) > 0)        
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                           echo '<option value="'.$row['id'].'">'.$row['id'].' - '.$roomType.'</option>';
                        }
                    }
                  ?>
                </select>
              </div>
            </div>
            
            <div class="form-group">
              <label>Person Name <small style="color: red;">* eg. John Doe</small></label>
              <input type="text" class="form-control" name="pname" placeholder="Enter Person Name" required>
            </div>

            <div class="form-group">
              <label>Card Number <small style="color: red;">* eg. 1234 5678 435678</small></label>
              <input type="text" class="form-control" name="cnum" placeholder="1234 5678 435678" required>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Expiry <small style="color: red;">* eg. 12/25</small></label>
                  <input type="text" name="expiry" placeholder="MM/YY" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>CVV/CVC <small style="color: red;">* eg. 123</small></label>
                  <input type="password" name="cvc" placeholder="***" class="form-control" required>
                </div>
              </div>
            </div>
            
            <div class="form-group">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th colspan="2"> Reservation Details </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Date Start: </td>
                                <td><?php echo date('Y-m-d H:i:s',strtotime($roomstart)); ?></td>
                            </tr>
                            <tr>
                                <td>Date End: </td>
                                <td><?php echo date('Y-m-d H:i:s',strtotime($roomend)); ?></td>
                            </tr>
                            <tr>
                                <td>Total Amount: </td>
                                <td>$<?php echo $amount; ?></td>
                            </tr>
                        </tbody>
                </table>
              </div>


            
            <div class="form-group">
              <!-- Date Start -->
              <input type="hidden" name="date_start" value=<?php echo $roomstart;?>> 
              <!-- Date Start -->

              <!-- Date End -->
              <input type="hidden" name="date_end" value=<?php echo $roomend;?>>
              <!-- Date End -->

              <!-- Amount -->
              <input type="hidden" name="amount" value=<?php echo $amount;?>>
              <!-- Amount -->

              <!-- Room Id -->
              <input type="hidden" name="roomID" value=<?php echo $roomID;?>>
              <!-- Room Id -->

              <!-- User Id -->
              <input type="hidden" name="customer_id" value=<?php echo $userid;?>>
              <!-- User Id -->
              <button type="submit" class="btn btn-primary btn-lg" id="submit" name="payroom">
                Pay Room
              </button>
            </div>
          </form>
        </div>





        <div class="col-md-4">
          <h2 class="mt0">Feedback</h2>
          <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
          <p><a href="#" class="btn btn-primary" role="button">Send Message</a></p>
        </div>
      </div>
    </div>
  </section>

  <?php 
   $slider = "SELECT * FROM slider";
   $slider_run = mysqli_query($connection, $slider);
   
   if($slider_run)
   {   
     $imgSR = mysqli_fetch_assoc($slider_run);   
     $imgF = $imgSR['image']; 
?>
  <section class="probootstrap-half">
    <div class="image" style="background-image: url(admin/upload/<?php echo $imgF;?>);"></div>
    <div class="text">
      <div class="probootstrap-animate fadeInUp probootstrap-animated">
        <h2 class="mt0">Best 5 Star hotel</h2>
        <p><img src="img/curve_white.svg" class="seperator" alt="Free HTML5 Bootstrap Template"></p>
        <div class="row">
          <div class="col-md-6">
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>    
          </div>
          <div class="col-md-6">
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>    
          </div>
        </div>
        <p><a href="#" class="link-with-icon white">Learn More <i class=" icon-chevron-right"></i></a></p>
      </div>
    </div>
  </section>
<?php
  }
  else
  {
?>
  <section class="probootstrap-half">
    <div class="image" style="background-image: url(img/slider_2.jpg);"></div>
    <div class="text">
      <div class="probootstrap-animate fadeInUp probootstrap-animated">
        <h2 class="mt0">Best 5 Star hotel</h2>
        <p><img src="img/curve_white.svg" class="seperator" alt="Free HTML5 Bootstrap Template"></p>
        <div class="row">
          <div class="col-md-6">
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>    
          </div>
          <div class="col-md-6">
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>    
          </div>
        </div>
        <p><a href="#" class="link-with-icon white">Learn More <i class=" icon-chevron-right"></i></a></p>
      </div>
    </div>
  </section>
<?php 
  }
?>


<?php
include('footer.php');
?>