<?php
include('security.php');
$cuser = "customer";
$roomdb = "room";
$reservation = "reservation";
$transaction = "transaction";
$penalty = "penalty";
$payment = "payment";
// FOR CUSTOMER
if(isset($_POST['registerbtn_customer']))
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];





    $email_query = "SELECT * FROM $cuser WHERE email='$email' ";
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
            $query = "INSERT INTO $cuser (fname,lname,email,password) VALUES ('$fname','$lname','$email','$password')";
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


if(isset($_POST['submitReservation']))
{
    $customer_id = $_POST['customer_id'];
    $room_id = $_POST['room'];
    $arrival = strtotime($_POST["date-start"]);
    $departure = strtotime($_POST["date-end"]);
    $start_date = date('Y-m-d H:i:s',$arrival);
    $end_date = date('Y-m-d H:i:s',$departure);
    //echo date("Mdmy") . "<br>";
    // echo date("m/d/Y H:i:s") . "<br>";

    $get_room =  "SELECT * FROM $roomdb WHERE id = '$room_id'";
    $get_room_run = mysqli_query($connection, $get_room);
    foreach($get_room_run as $ro_row)
    {
        $room_type = $ro_row['type'];
        $price = $ro_row['price'];
    }

    $interval = getInterval($start_date,$end_date);
    $amount_pay = $interval->days * $price;

    $query = "INSERT INTO $reservation (customer_id, room_id, date_start, date_end, amount_pay) VALUES ('$customer_id','$room_id','$start_date','$end_date','$amount_pay')";
    $query_run = mysqli_query($connection, $query);



    $cust_name = getFname($cuser,$customer_id,$connection);



    $count = getCount($reservation,$connection);


    $reservation_id = grabReservationId($reservation,$connection);

    $name = substr($cust_name,0,2);
    $month_added = date('M');
    $date_added = date('d');
    $month_year = date('my');
    $room_name = substr($room_type,0,3);
    $room_trans_id = sprintf('%05d',$reservation_id);
    //return example
    //2 letters from name, month in 3 letters format ex matthew- ma, FEB, 
    //number day added to the system ex - 01-31 ,
    //month and year of reservation eg.feb22 - feb -> 02, 2022 -> 22 = 0222
    //3 letters from room type ex- KING -> KIN
    //COUNT OF RESERVATION FROM 5 digit format ex- 00001
    //MAFEB100222-KIN00001

    $transaction_id = strtoupper("$name$month_added$date_added$month_year-$room_name$room_trans_id");

    $query = "INSERT INTO $transaction (id, reservation_id) VALUES ('$transaction_id','$reservation_id')";
    $query_run = mysqli_query($connection, $query);
    header('Location: index.php');
}


if(isset($_POST['editReservation']))
{
    $customer_id = $_POST['customer_id'];
    $room_id = $_POST['room'];
    $arrival = strtotime($_POST["date-start"]);
    $departure = strtotime($_POST["date-end"]);
    $start_date = date('Y-m-d H:i:s',$arrival);
    $end_date = date('Y-m-d H:i:s',$departure);
    $reservation_id = $_POST['reservation_id'];


    $get_room =  "SELECT * FROM $roomdb WHERE id = '$room_id'";
    $get_room_run = mysqli_query($connection, $get_room);
    foreach($get_room_run as $ro_row)
    {
        $room_type = $ro_row['type'];
        $price = $ro_row['price'];
    }

    $selection = "SELECT * FROM $reservation WHERE id = '$reservation_id'";
    $query_selection_run =  mysqli_query($connection, $selection);
    foreach($query_selection_run as $select_row)
    {
        $STARTDATE = date('Y-m-d H:i:s',strtotime($select_row['date_start']));
        $ENDDATE = date('Y-m-d H:i:s',strtotime($select_row['date_end']));
    }

    $interval = getInterval($STARTDATE,$ENDDATE);

    $amount_pay = $interval->days * $price;

    $query_update = "UPDATE $reservation 
    SET room_id = '$room_id', amount_pay = '$amount_pay' WHERE id = '$reservation_id'";
    $query_update_run = mysqli_query($connection, $query_update);

    //NEW ROOM NAME
    $room_name = strtoupper(substr($room_type,0,3));

    $transaction_room = "SELECT * FROM $transaction WHERE reservation_id = '$reservation_id'";
    $transaction_room_run = mysqli_query($connection, $transaction_room);
    foreach($transaction_room_run as $TRANSROOM)
    {
        $TRANSID = $TRANSROOM['id'];
    }

    $search = substr($TRANSID,12,3);
    $NEWTRANSID = str_replace($search,$room_name,$TRANSID);


    $transaction_id = strtoupper($NEWTRANSID);
    $query = "UPDATE $transaction SET id = '$transaction_id' WHERE reservation_id = '$reservation_id'";
    $query_run = mysqli_query($connection, $query);
    header('Location: book.php');

}





if(isset($_POST['cancel_room']))
{
    $id = $_POST['cancel_id'];


    $start_date = "SELECT * FROM $reservation WHERE id = '$id'";
    $start_run = mysqli_query($connection, $start_date);
    foreach($start_run as $row)
    {
        $custId = $row['customer_id'];
        $roomId = $row['room_id'];
        $dateStart = date('Y-m-d H:i:s',strtotime($row['date_start']));
        $dateEnd = date('Y-m-d H:i:s',strtotime($row['date_end']));
        $amountPay = $row['amount_pay'];
    }
    $today_date = date('Y-m-d H:i:s');

    $diff = getInterval($today_date,$dateEnd);


    if($diff >= 5)
    {
        $amountPay = $amountPay * .1;
        $query = "INSERT INTO $payment (customer_id, amount) VALUES ('$custId','$amountPay')";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $transaction WHERE reservation_id = '$id'";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $reservation WHERE id = '$id'";
        $query_run = mysqli_query($connection, $query);
     
        if($query_run)
        {
            $_SESSION['status'] = "Your Room '$id' is Canceled";
            $_SESSION['status_code'] = "success";
            header('Location: book.php'); 
        }
        else
        {
            $_SESSION['status'] = "Your Room '$id' is Canceled";       
            $_SESSION['status_code'] = "error";
            header('Location: book.php'); 
        }    
    }
    else if($diff > 2 && $diff < 5)
    {
        $amountPay = $amountPay * .15;
        $query = "INSERT INTO $payment (customer_id, amount) VALUES ('$custId','$amountPay')";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $transaction WHERE reservation_id = '$id'";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $reservation WHERE id = '$id'";
        $query_run = mysqli_query($connection, $query);
     
        if($query_run)
        {
            $_SESSION['status'] = "Your Room '$id' is Canceled";
            $_SESSION['status_code'] = "success";
            header('Location: book.php'); 
        }
        else
        {
            $_SESSION['status'] = "Your Room '$id' is Canceled";       
            $_SESSION['status_code'] = "error";
            header('Location: book.php'); 
        }    
    }
    else if($diff <= 2)
    {
        $amountPay = $amountPay * .2;

        $query = "INSERT INTO $payment (customer_id, amount) VALUES ('$custId','$amountPay')";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $transaction WHERE reservation_id = '$id'";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $reservation WHERE id = '$id'";
        $query_run = mysqli_query($connection, $query);
     
        if($query_run)
        {
            $_SESSION['status'] = "Your Room '$id' is Canceled";
            $_SESSION['status_code'] = "success";
            header('Location: book.php'); 
        }
        else
        {
            $_SESSION['status'] = "Your Room '$id' is Canceled";       
            $_SESSION['status_code'] = "error";
            header('Location: book.php'); 
        }
    }






   
}





//FUNCTIONS FUNCTIONS FUNCTIONS FUNCTIONS FUNCTIONS FUCNTIONS
function getFname($cuser,$customer_id,$connection)
{

    $get_customer = "SELECT * FROM $cuser WHERE id = $customer_id";
    $get_customer_run = mysqli_query($connection,$get_customer);

    foreach($get_customer_run as $cust_row)
    {
        $cust_name = $cust_row['fname'];
    }

    return $cust_name;
}

function getCount($reservation,$connection)
{
    $get_reservation_count = "SELECT COUNT(*) AS A FROM $reservation";
    $get_reservation_count_run = mysqli_query($connection, $get_reservation_count);

    foreach($get_reservation_count_run as $res_count)
    {
        $count = $res_count['A'];
    }

    return $count;
}


function grabReservationId($reservation,$connection)
{
    $get_reservation_id = "SELECT max(id) AS B FROM $reservation";
    $get_reservation_id_run = mysqli_query($connection, $get_reservation_id);

    foreach($get_reservation_id_run as $resid)
    {
        $reservation_id = $resid['B'];
    }

    return $reservation_id;
}

function getInterval($start_date,$end_date)
{
    $newDate = new DateTime($start_date);
    $newEndDate = new DateTime($end_date);
    $interval = $newDate->diff($newEndDate);

    return $interval;
}





 

?>