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
      $res_id = $_POST['edit_reservationId'];
      $g = "SELECT * FROM reservation WHERE id = '$res_id'";
      $g_run = mysqli_query($connection, $g);
      $row = mysqli_fetch_assoc($g_run);
      $roomID = $row['room_id'];
      
      $ad = "SELECT * FROM room WHERE id = '$roomID'";
      $a_run = mysqli_query($connection, $ad);

      $a = mysqli_fetch_assoc($a_run);
      $roomType = $a['type'];

      
      $query = "SELECT * FROM room_number 
      WHERE room_number.id NOT IN (SELECT room_number FROM room_reserved) 
      AND room_number.room_id = '$roomID'";
      $query_run = mysqli_query($connection, $query);
    ?>
    <div class="container">
      <div class="row probootstrap-gutter40">
        <div class="col-md-8">
          <h2 class="mt0">Change Room Form</h2>
          <form action="code.php" method="post" class="probootstrap-form">
            <div class="form-group">
              <label for="room">Room</label>
              <div class="form-field">
                <i class="icon icon-chevron-down"></i>
                <select name="room" id="room" class="form-control">
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
              <input type="hidden" name="customer_id" value=<?php echo $userid;?>>
              <input type="hidden" name="reservation_id" value=<?php echo $res_id;?>>
              <button type="submit" class="btn btn-primary btn-lg" id="submit" name="editReservation">
                Change Room
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
include('footer.php');
?>