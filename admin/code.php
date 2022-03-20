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
    $edit_quantity = $_POST['edit_quantity'];
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

    $query = "UPDATE $roomdb SET title='$edit_title', type='$edit_type', image='$image_data', description='$edit_description', quantity ='$edit_quantity',  price ='$edit_price' WHERE id='$edit_id' ";
    $query_run = mysqli_query($connection, $query);

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


if(isset($_POST['applyRoom']))
{
    $query = "SELECT * FROM room";
    $query_run = mysqli_query($connection, $query);
    if(mysqli_num_rows($query_run) > 0)
    {
        while($row =  mysqli_fetch_assoc($query_run))
        {
            $id = $row['id'];
            $quantity = $row['quantity'];
            for($i = 0; $i < $quantity; $i++)
            {
                $query_aw = "INSERT INTO room_number (room_id) VALUES ('$id')";
                $query_aw_run = mysqli_query($connection, $query_aw);
                if($query_aw_run)
                {
                    $_SESSION['status'] = "Rooms are now applied";
                    header('Location: rooms.php'); 
                }
            }
        }
    } else
    {

    }
}


?>


