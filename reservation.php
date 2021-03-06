<?php
$roomdb = "room";
include('security.php');
include('header.php');
?>

<?php 
 $query = "SELECT * FROM slider";
 $query_run = mysqli_query($connection, $query);
 
 if($query_run)
 {
    $row = mysqli_fetch_assoc($query_run);
    $image = $row['image'];
?>
<section class="probootstrap-slider flexslider probootstrap-inner">
    <ul class="slides">
       <li style="background-image: url(admin/upload/<?php echo $image;?>);" class="overlay">
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
<?php 
 }
 else
 {
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
<?php 
 }
?>

  <?php 
    $query = "SELECT * FROM room_number 
    WHERE room_number.id NOT IN (SELECT room_number FROM room_reserved)";
    $query_run = mysqli_query($connection,$query);
    if(mysqli_num_rows($query_run) > 0)
    {
  ?>
  
  <section class="probootstrap-section">
  <?php
      $query = "SELECT * FROM $roomdb";
      $query_run = mysqli_query($connection, $query);
            ?>
    <div class="container">
      <div class="row probootstrap-gutter40">
        <div class="col-md-8">
          <h2 class="mt0">Reservation Form</h2>
          <form action="code.php" method="post" class="probootstrap-form">
            <div class="form-group">
              <label for="room">Room</label>
              <div class="form-field">
                <i class="icon icon-chevron-down"></i>
                <select name="room" id="room" class="form-control" required>
                  <option value="">Select a Room</option>
                  <?php 
                    if(mysqli_num_rows($query_run) > 0)        
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                           echo '<option value="'.$row['id'].'">'.$row['type'].'</option>';
                        }
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="date-start">Arrival</label>
                  <div class="form-field">
                    <input type="datetime-local" class="form-control" id="date-start" name="date-start" min="<?php echo $min; ?>" required>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="date-end">Departure</label>
                  <div class="form-field">
                    <input type="datetime-local" class="form-control" id="date-end" name="date-end" min="<?php echo $min2; ?>" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input type="hidden" name="customer_id" value=<?php echo $userid;?>>
              <button type="submit" class="btn btn-primary btn-lg" id="submit" name="submitReservation">
                Reserve
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
    }
    else
    {
      include('full_reservation.php');
    }
  ?>



<?php include('extra.php')?> 



<?php
include('footer.php');
?>