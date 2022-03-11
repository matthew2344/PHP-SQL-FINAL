<?php
include('security.php');
include('header.php');
?>


<section class="probootstrap-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <?php
            if(isset($_SESSION['success']) && $_SESSION['success'] !='')
            {
            echo '<h2>' .$_SESSION['success']. '</h2>';
            unset($_SESSION['success']);
            }

            if(isset($_SESSION['status']) && $_SESSION['status'] !='')
            {
            echo '<h2 class="bg-info">' .$_SESSION['status']. '</h2>';
            unset($_SESSION['status']);
            }
        ?>

            <div class="table-responsive">
            <?php
                $query = "SELECT room.title, room.type, room.price, reservation.id, reservation.date_start, reservation.date_end FROM reservation INNER JOIN room ON room.id = reservation.room_id 
                WHERE reservation.customer_id = $userid";
                $query_run = mysqli_query($connection, $query);
            ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th> Title </th>
                    <th> Room Type </th>
                    <th> Date Start </th>
                    <th> Date End </th>
                    <th> Amount Pay/night </th>
                    <th> EDIT </th>
                    <th> CANCEL </th>
                    </tr>
                </thead>
                <tbody>
                <?php
            if(mysqli_num_rows($query_run) > 0)        
            {
                while($row = mysqli_fetch_assoc($query_run))
                {
          ?>
                    <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['date_start']; ?></td>
                    <td><?php echo $row['date_end']; ?></td>
                    <td><?php echo $row['price']; ?></td>

                    <td>
                        <form action="book_edit.php" method="post">
                            <input type="hidden" name="edit_reservationId" value="<?php echo $row['id']; ?>">
                            <button  type="submit" name="reservation_edit" class="btn btn-success"> EDIT</button>
                        </form>
                    </td>
                    <td>
                        <form action="code.php" method="post">
                            <input type="hidden" name="cancel_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="cancel_room" class="btn btn-danger"> CANCEL</button>
                        </form>
                    </td>
                    </tr>
                    <?php
                } 
            }
            else {
            echo "No Record Found";
            }
          ?>
                </tbody>
                </table>

            </div>
        </div>
      </div>
    </div>
</section>












<?php include('footer.php')?>