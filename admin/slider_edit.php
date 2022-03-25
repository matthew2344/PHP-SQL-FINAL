<?php
$roomdb = "room";
include('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> EDIT Room info </h6>
        </div>
        <div class="card-body">
        <?php
            if(isset($_POST['edit_slider_id']))
            {
                $id = $_POST['edit_slider_id'];
                
                $query = "SELECT * FROM slider WHERE id='$id'";
                $query_run = mysqli_query($connection, $query);

                foreach($query_run as $row)
                {
                    ?>
                        <form action="code.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="edit_id" value="<?php echo $row['id'] ?>">

                            <div class="form-group">
                                <label> Image </label>
                                <input type="file" name="slide_image" id="slide_image" value="<?php echo $row['image'] ?>" class="form-control"
                                    placeholder="Enter Image">
                            </div>

                            <div class="form-group">
                                <label>Header</label>
                                <input type="text" name="edit_header" value="<?php echo $row['header'] ?>" class="form-control"
                                    placeholder="Enter description">
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="edit_description" value="<?php echo $row['description'] ?>" class="form-control"
                                    placeholder="Enter description">
                            </div>


                            <a href="slider.php" class="btn btn-danger"> CANCEL </a>
                            <button type="submit" name="update_slider" class="btn btn-primary"> Update </button>

                        </form>
                        <?php
                }
            }
        ?>
        </div>
    </div>
</div>

</div>


<?php
include('includes/scripts.php');
include('includes/footer.php');
?>