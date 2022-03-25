<?php
$roomdb = "room";
include('security.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="modal fade" id="addSlider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Slider</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST" enctype="multipart/form-data">

        <div class="modal-body">
          
            <div class="form-group">
                <label>Upload Image</label>
                <input type="file" name="slide_image" class="form-control" placeholder="Upload Image" required>
            </div>

            <div class="form-group">
                <label>Header</label>
                <input type="text" name="slider_header" class="form-control" placeholder="Enter Header Text" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <input type="text" name="slider_description" class="form-control" placeholder="Enter Description Text" required>
            </div>

        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="uploadImage" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Slider 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSlider">
              ADD
            </button>
    </h6>
  </div>

  <div class="card-body">

  <?php
      $query = "SELECT * FROM slider";
      $query_run = mysqli_query($connection, $query);
            ?>
    <div class="table-responsive">

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> ID </th>
            <th>File name</th>
            <th>Image</th>
            <th>Header</th>
            <th>Description</th>
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
            <td><?php  echo $row['image']; ?></td>
            <td><?php  echo '<img src="upload/'.$row['image'].'" alt="" width="100px;" height="100px;" alt="Image">'?></td>
            <td><?php  echo $row['header']; ?></td>
            <td><?php  echo $row['description']; ?></td>
            <td>
                <form action="slider_edit.php" method="post">
                    <input type="hidden" name="edit_slider_id" value=<?php echo $row['id']?>>
                    <button  type="submit" name="edit_slider" class="btn btn-success"> EDIT</button>
                </form>
            </td>
            <td>
                <form action="code.php" method="post">
                  <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="delete_slider" class="btn btn-danger"> DELETE</button>
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