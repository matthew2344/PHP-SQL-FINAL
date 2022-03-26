<?php
$roomdb = "room";
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="modal fade" id="roomsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Room Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="code.php" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
          
            <div class="form-group">
              <label>Room title</label>
              <input type="text" name="room_title" class="form-control" placeholder="Enter room type" required>
            </div>
            <div class="form-group">
                <label>Room Type</label>
                <input type="text" name="room_type" class="form-control" placeholder="Enter room type" required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="room_image" class="form-control" placeholder="Upload Image" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" name="room_description" class="form-control" placeholder="Enter Description" required>
            </div>
            <div class="form-group">
                <label>Quantity <small style="color:red;">*Room quantity is permanent and it cannot be changed afterwards</small></label>
                <input type="number" name="room_quantity" class="form-control" placeholder="Enter quantity of rooms" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="text" name="room_price" class="form-control" placeholder="Enter room price" required>
            </div>

        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add_room" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>




<!-- DataTales Example -->
<div class="card shadow mb-4">
<?php 

if(isset($_SESSION['error_room_delete']) && $_SESSION['error_room_delete'] !='') 
{
    echo '<h2 class="bg-danger text-white"> '.$_SESSION['error_room_delete'].' </h2>';
    unset($_SESSION['error_room_delete']);
}

if(isset($_SESSION['status']) && $_SESSION['status'] !='') 
{
    echo '<h2 class="bg-danger text-white"> '.$_SESSION['status'].' </h2>';
    unset($_SESSION['status']);
}

?>
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Rooms 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#roomsModal">
              ADD
            </button>
    </h6>
  </div>

  <div class="card-body">

  <?php
      $query = "SELECT * FROM $roomdb";
      $query_run = mysqli_query($connection, $query);
            ?>
    <div class="table-responsive">

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            <th> Title </th>
            <th>Type </th>
            <th>Image</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>EDIT </th>
            <th>DELETE </th>
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
            <td><?php  echo $row['id']; ?></td>
            <td><?php  echo $row['title']; ?></td>
            <td><?php  echo $row['type']; ?></td>
            <td><?php echo '<img src="upload/'.$row['image'].'" alt="" width="100px;" height="100px;" alt="Image">'?></td>
            <td><?php  echo $row['description']; ?></td>
            <td><?php  echo $row['quantity']; ?></td>
            <td><?php  echo "$".$row['price']; ?></td>
            <td>
                <form action="rooms_edit.php" method="post">
                    <input type="hidden" name="edit_id" value=<?php echo $row['id']?>>
                    <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_room_btn" class="btn btn-danger"> DELETE</button>
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
<!-- /.container-fluid -->

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>