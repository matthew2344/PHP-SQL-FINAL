<?php
include('security.php');
$user = "admins";
$cuser = "customer";
$roomdb = "room";
$reservation = "reservation";
// FOR ADMIN

if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];

    $email_query = "SELECT * FROM $user WHERE email='$email' ";
    $email_query_run = mysqli_query($connection, $email_query);
    if(mysqli_num_rows($email_query_run) > 0)
    {
        $_SESSION['status'] = "Email Already Taken. Please Try Another one.";
        $_SESSION['status_code'] = "error";
        header('Location: register.php');  
    }
    else
    {
        if($password === $cpassword)
        {
            $query = "INSERT INTO $user (username,email,password) VALUES ('$username','$email','$password')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                // echo "Saved";
                $_SESSION['status'] = "User Profile Added";
                $_SESSION['status_code'] = "success";
                header('Location: register.php');
            }
            else 
            {
                $_SESSION['status'] = "User Profile Not Added";
                $_SESSION['status_code'] = "error";
                header('Location: register.php');  
            }
        }
        else 
        {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: register.php');  
        }
    }

}

if(isset($_POST['edit_btn']))
{
    $id = $_POST['edit_id'];
    $query = "SELECT * FROM $user WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);
}




if(isset($_POST['updatebtn']))
{
    $id = $_POST['edit_id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];
    $usertypeupdate = $_POST['update_user_type'];

    $query = "UPDATE $user SET username='$username', email='$email', password='$password' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    }
}

if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM $user WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Your Data is Deleted";
        $_SESSION['status_code'] = "success";
        header('Location: register.php'); 
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT DELETED";       
        $_SESSION['status_code'] = "error";
        header('Location: register.php'); 
    }    
}

if(isset($_POST['login_btn']))
{
    $email_login = $_POST['emaill']; 
    $password_login = $_POST['passwordd']; 

    $query = "SELECT * FROM $user WHERE email='$email_login' AND password='$password_login' ";
    $query_run = mysqli_query($connection, $query);

   if(mysqli_fetch_array($query_run))
   {
        $_SESSION['username'] = $email_login;
        header('Location: index.php');
   } 
   else
   {
        $_SESSION['status'] = "Email / Password is Invalid";
        header('Location: login.php');
   }
    
}

if(isset($_POST['uploadImage']))
{
    $image = $_FILES["slide_image"]['name'];
    $header = $_POST['slider_header'];
    $description = $_POST['slider_description'];

    if(file_exists("upload/" . $_FILES["slide_image"]["name"]))
    {
        $store = $_FILES["slide_image"]["name"];
        $_SESSION['status'] = "Image already exists. '.$store.'";
        header('Location: slider.php');
    }
    else
    {
        $query = "INSERT INTO slider (image, header, description) VALUES ('$image','$header','$description')";
        $query_run = mysqli_query($connection, $query);

        if($query_run)
        {
            move_uploaded_file($_FILES["slide_image"]["tmp_name"],"upload/".$_FILES["slide_image"]["name"]);
            $_SESSION['success'] = "Slide Added";
            header('Location: slider.php');
        }
        else
        {
            $_SESSION['success'] = "Slide not Added";
            header('Location: slider.php');
        }
    }
}

if(isset($_POST['update_slider']))
{
    $slideID = $_POST['edit_id'];
    $image = $_FILES["slide_image"]['name'];
    $header = $_POST['edit_header'];
    $description = $_POST['edit_description'];

    $validate = "SELECT * FROM slider WHERE id = '$slideID'";
    $validate_run = mysqli_query($connection, $validate);
    foreach($validate_run as $row)
    {
        if($image == NULL)
        {
            $image_data = $row['image'];
        }
        else
        {
            if($img_path = "upload/".$row['image'])
            {
                unlink($img_path);
                $image_data = $image;
            }
        }
    }

    $query = "UPDATE slider SET image = '$image_data', header = '$header', description = '$description' WHERE id = '$slideID'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        if($image == NULL)
        {
            $_SESSION['success'] = "Slider Updated with existing image";
            header('Location: slider.php'); 
        }
        else
        {
            move_uploaded_file($_FILES["slide_image"]["tmp_name"],"upload/".$_FILES["slide_image"]["name"]);
            $_SESSION['status'] = "Your Data is Updated";
            $_SESSION['status_code'] = "success";
            header('Location: slider.php'); 
        }
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: slider.php'); 
    }

}


if(isset($_POST['add_room']))
{
    $title = $_POST['room_title'];
    $type = $_POST['room_type'];
    $description = $_POST['room_description'];
    $quantity = $_POST['room_quantity'];
    $image = $_FILES["room_image"]['name'];
    $price = $_POST['room_price'];
    
    if(file_exists("upload/" . $_FILES["room_image"]["name"]))
    {  
        $store = $_FILES["room_image"]["name"];
        $_SESSION['status']= "Image already exists. '.$store.'";
        header('Location: rooms.php');
    }   
    else
    {
        $query = "INSERT INTO $roomdb (title,type,image,description,quantity,price) VALUES ('$title','$type','$image','$description','$quantity','$price')";
        $query_run = mysqli_query($connection, $query);
        $roomId = mysqli_insert_id($connection);
        
        for($i=0;$i<$quantity;$i++)
        {
            $addRoom = "INSERT INTO room_number (room_id) VALUES ($roomId)";
            $addRoom_run = mysqli_query($connection,$addRoom);
        }

        
        if($query_run)
        {
            move_uploaded_file($_FILES["room_image"]["tmp_name"],"upload/".$_FILES["room_image"]["name"]);
            $_SESSION['success'] = "Rooms Added";
            header('Location: rooms.php');
        }   
        else
        {
            $_SESSION['success'] = "Rooms Not Added";
            header('Location: rooms.php');
        }
    }
}


if(isset($_POST['rooms_updatebtn']))
{
    $edit_title = $_POST['edit_title'];
    $edit_id = $_POST['edit_id'];
    $edit_type = $_POST['edit_type'];
    $edit_image = $_FILES["room_image"]['name'];
    $edit_description = $_POST['edit_description'];
    $edit_price = $_POST['edit_price'];

    $room_query = "SELECT * FROM $roomdb WHERE id='$edit_id' ";
    $room_query_run = mysqli_query($connection,$room_query);
    foreach($room_query_run as $ro_row)
    {
        if($edit_image == NULL)
        {
            // Update with existing Image
            $image_data = $ro_row['image'];
        }
        else
        {
            // Update with new image and delete old image
            if($img_path = "upload/".$ro_row['image'])
            {
                unlink($img_path);
                $image_data = $edit_image;
            }
            
        }
    }


    $query = "UPDATE $roomdb SET title='$edit_title', type='$edit_type', image='$image_data', description='$edit_description', price ='$edit_price' WHERE id='$edit_id' ";
    $query_run = mysqli_query($connection, $query);

    $typeReplace = substr($edit_type,0,3);
    $replace = strtoupper($typeReplace);

    $select = "SELECT a.* FROM transaction a
    INNER JOIN reservation ON reservation.id = a.reservation_id
    INNER JOIN room ON room.id = reservation.room_id 
    WHERE room.id = '$edit_id'";
    $select_run= mysqli_query($connection,$select);
    if($select_run)
    {
        while($row = mysqli_fetch_assoc($select_run))
        {
            $id = $row['id'];
            $newID = substr_replace($id,$replace,12,3);
            $temp = "UPDATE transaction SET id = '$newID' WHERE id = '$id'";
            $temp_run = mysqli_query($connection,$temp);
        }
    }
    

    if($query_run)
    {
        if($edit_image == NULL)
        {
            // Update with existing Image
            $_SESSION['success'] = "Room Updated with existing image";
            header('Location: rooms.php'); 
        }
        else
        {
            // Update with new image and delete old image
            move_uploaded_file($_FILES["room_image"]["tmp_name"],"upload/".$_FILES["room_image"]["name"]);
            $_SESSION['status'] = "Your Data is Updated";
            $_SESSION['status_code'] = "success";
            header('Location: rooms.php'); 
        }
        
    }
    else
    {
        $_SESSION['status'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: rooms.php'); 
    }
}



if(isset($_POST['delete_room_btn']))
{
    $id = $_POST['delete_id'];

    $check = "SELECT * FROM room_number 
    WHERE room_number.id IN (SELECT room_number FROM room_reserved)
    AND room_number.room_id = '$id'";
    $check_run = mysqli_query($connection, $check);

    if(mysqli_num_rows($check_run) > 0)
    {
        $_SESSION['error_room_delete'] = "Cannot be deleted.. There are still customer using this type of room ";
        header('Location: rooms.php');
    }
    else
    {
        $query = "DELETE FROM room_number WHERE room_id='$id' ";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $roomdb WHERE id='$id' ";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $_SESSION['status'] = "Your Data is Deleted";
            $_SESSION['status_code'] = "success";
            header('Location: rooms.php'); 
        }
        else
        {
            $_SESSION['status'] = "Your Data is NOT DELETED";       
            $_SESSION['status_code'] = "error";
            header('Location: rooms.php'); 
        }    
    }



}





?>


