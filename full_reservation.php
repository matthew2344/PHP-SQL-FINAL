

  <section class="probootstrap-section">
    <div class="container">
      <div class="row probootstrap-gutter40">
        <div class="col-md-8">
          <h2 class="mt0 text-center" style="color: red;">Sorry reservation is full</h2>

          <?php 
          $query = "SELECT MIN(date_end) AS mindate FROM reservation";
          $query_run = mysqli_query($connection,$query);
          if($query_run)
          {
            $date_row = mysqli_fetch_assoc($query_run);
          }
          $min_date = $date_row['mindate'];
          ?>
          <div class="form-group">
            <h3 class="mt0 text-center">There are no available rooms</h3>
            <h4 class="mt0 text-center">Hotel is at its maximum reservation until <?php echo $min_date;?></h4>
          </div>
        </div>

        <div class="col-md-4">
          <h2 class="mt0">Feedback</h2>
          <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
          <p><a href="#" class="btn btn-primary" role="button">Send Message</a></p>
        </div>
      </div>
    </div>
  </section>

