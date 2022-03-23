<?php
include('security.php');
$cuser = "customer";
$roomdb = "room";
$reservation = "reservation";
$transaction = "transaction";
$penalty = "penalty";
$payment = "payment";
// FOR CUSTOMER
// substr_replace("MAMAR230322-KIN00024","YYY",12,3);
class card{
    public $pname;
    public $num;
    public $expiry;
    public $cvc;

    function __construct($pname,$num,$expiry,$cvc)
    {
        $this->pname = $pname;
        $this->num = $num;
        $this->expiry = $expiry;
        $this->cvc = $cvc;
    }

    function validateCard()
    {
        $server_name = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "test";
        $connection = mysqli_connect($server_name,$db_username,$db_password,$db_name);

        $query = "SELECT * FROM card WHERE id = '$this->num' AND person_name = '$this->pname'
         AND expiry = '$this->expiry' AND cvc = '$this->cvc'";
        $query_run = mysqli_query($connection,$query);

        if(mysqli_num_rows($query_run) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
}

class transaction{
    public $id;

    function __construct($name,$month_added,$date_added,$month_year,$room_name,$room_trans_id)
    {
       $this->id = strtoupper("$name$month_added$date_added$month_year-$room_name$room_trans_id");
    }
}

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
    $arrival = $_POST["date-start"];
    $departure = $_POST["date-end"];
    $start_date = date('Y-m-d H:i:s',strtotime($arrival));
    $end_date = date('Y-m-d H:i:s',strtotime($departure));

    $get_room =  "SELECT * FROM $roomdb WHERE id = '$room_id'";
    $get_room_run = mysqli_query($connection, $get_room);
    foreach($get_room_run as $ro_row)
    {
        $room_type = $ro_row['type'];
        $price = $ro_row['price'];
    }

    $interval = getInterval($start_date,$end_date);
    $amount_pay = $interval->days * $price;




    $room_name = substr($room_type,0,3);





    $_SESSION['roomID'] = $room_id;
    $_SESSION['date_start'] = $arrival;
    $_SESSION['date_end'] = $departure;
    $_SESSION['amount'] = $amount_pay;

    header('Location: pay_room.php');

    
}

if(isset($_POST['payroom']))
{
    $customerId = $_POST['customer_id'];
    $roomNumber = $_POST['room'];
    $roomId = $_POST['roomID'];
    $date_start = date('Y-m-d H:i:s',strtotime($_POST['date_start']));
    $date_end = date('Y-m-d H:i:s',strtotime($_POST['date_end']));
    $amount = $_POST['amount'];

    // CARD INFO
    $pname = $_POST['pname'];
    $cnum = $_POST['cnum'];
    $expiry = $_POST['expiry'];
    $cvc = $_POST['cvc'];
    $card = new card($pname,$cnum,$expiry,$cvc);
    
    if($card->validateCard() == true)
    {
        $query = "SELECT * FROM room WHERE id ='$roomId'";
        $query_run = mysqli_query($connection,$query);
        if($query_run) { $roomRow = mysqli_fetch_assoc($query_run);}
        $cust_name = getFname($cuser,$customerId,$connection);
    
        // Variables for transaction
        $room_name = substr($roomRow['type'],0,3);
        $name = substr($cust_name,0,2);
        $month_added = date('M');
        $date_added = date('d');
        $month_year = date('my');
        // Variables for transaction
    
        
    
        $query = "INSERT INTO $reservation (customer_id, room_id, date_start, date_end, amount) VALUE ('$customerId','$roomId','$date_start','$date_end','$amount')";
        $query_run = mysqli_query($connection, $query);
        $reservation_id = mysqli_insert_id($connection);
        $room_trans_id = sprintf('%05d',$reservation_id);
        
    
    
        $query = "INSERT INTO room_reserved (room_number, reservation_id) VALUE ('$roomNumber', '$reservation_id')";
        $query_run = mysqli_query($connection, $query);
    
        $transObj = new transaction($name,$month_added,$date_added,$month_year,$room_name,$room_trans_id);
        $transaction_id = $transObj->id;

        $query = "INSERT INTO $transaction (id, reservation_id, customer_id, card_id, amount_pay) VALUES ('$transaction_id','$reservation_id','$customerId','$card->num','$amount')";
        $query_run = mysqli_query($connection, $query);


        $query = "UPDATE card SET balance = (balance - '$amount') WHERE id = '$card->num'";
        $query_run = mysqli_query($connection, $query);

    
        if($query_run)
        {

            unset($_SESSION['date_start']);
            unset($_SESSION['date_end']);
            unset($_SESSION['amount']);
            unset($_SESSION['roomID']);
            header('Location: index.php');
        }
        else
        {
            $_SESSION['ERROR'] = "Something Went Wrong";
            header('Location: pay_room.php');
        }
        
    }
    else
    {
        echo  "ERROR <br>";
        echo  $card->pname."<br>";
        echo  $card->num."<br>";
        echo  $card->expiry."<br>";
        echo  $card->cvc."<br>";
    }


}

if(isset($_POST['editReservation']))
{
    $customer_id = $_POST['customer_id'];
    $reservation_id = $_POST['reservation_id'];
    $room_no = $_POST['room'];

    $query = "UPDATE room_reserved SET room_number = '$room_no' WHERE reservation_id ='$reservation_id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        header('Location: index.php');
    }

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
    }

    $query = "SELECT * FROM $roomdb WHERE id = '$roomId'";
    $query_run= mysqli_query($connection, $query);
    foreach($query_run as $row)
    {
        $amountPay = $row['price'];
    }

    $today_date = date('Y-m-d H:i:s');
    
    $d1 = new DateTime($today_date);
    $d2 = new DateTime($dateEnd);
    $diff = getInterval($today_date,$dateEnd);

    
    if($diff->days >= 5)
    {
        $amountPay = $amountPay * .1;
        $get = "SELECT * FROM $transaction WHERE reservation_id = '$id'";
        $get_run = mysqli_query($connection, $get);
        if($get_run)
        {
            $row = mysqli_fetch_assoc($get_run);
        }
        $cardnumber = $row['card_id'];

        $query = "UPDATE card SET balance = (balance - '$amountPay') WHERE id = '$cardnumber'";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM room_reserved WHERE reservation_id = '$id'";
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
    else if($diff->days > 2 && $diff->days < 5)
    {
        $amountPay = $amountPay * .15;
        $get = "SELECT * FROM $transaction WHERE reservation_id = '$id'";
        $get_run = mysqli_query($connection, $get);
        if($get_run)
        {
            $row = mysqli_fetch_assoc($get_run);
        }
        $cardnumber = $row['card_id'];

        $query = "UPDATE card SET balance = (balance - '$amountPay') WHERE id = '$cardnumber'";
        $query_run = mysqli_query($connection, $query);
        
        $query = "DELETE FROM room_reserved WHERE reservation_id = '$id'";
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
    else if($diff->days <= 2 && $d1 > $d2)
    {
        $amountPay = $amountPay * .2;
        $get = "SELECT * FROM $transaction WHERE reservation_id = '$id'";
        $get_run = mysqli_query($connection, $get);
        if($get_run)
        {
            $row = mysqli_fetch_assoc($get_run);
        }
        $cardnumber = $row['card_id'];

        $query = "UPDATE card SET balance = (balance - '$amountPay') WHERE id = '$cardnumber'";
        $query_run = mysqli_query($connection, $query);


        $query = "DELETE FROM $transaction WHERE reservation_id = '$id'";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM $reservation WHERE id = '$id'";
        $query_run = mysqli_query($connection, $query);

        $query = "DELETE FROM room_reserved WHERE reservation_id = '$id'";
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


if(isset($_POST['ChangeInfoBtn']))
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $id = $_POST['updateid'];


    $query = "UPDATE customer SET fname='$fname', lname='$lname', email='$email' WHERE id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        $_SESSION['status_common'] = "Your Data is Updated";
        $_SESSION['status_code'] = "success";
        header('Location: profile.php'); 
    }
    else
    {
        $_SESSION['status_common'] = "Your Data is NOT Updated";
        $_SESSION['status_code'] = "error";
        header('Location: profile.php'); 
    }
}

if(isset($_POST['SaveNewPass']))
{
    $oldpass = $_POST['Oldpassword'];
    $newpass = $_POST['Newpassword'];
    $confirm = $_POST['confirmpassword'];
    $id = $_POST['updateid'];

    $query = "SELECT * FROM customer WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    foreach($query_run as $row)
    {
        $password = $row['password'];
    }

    

    if($oldpass === $password)
    {
        if($newpass === $confirm)
        {
            $query = "UPDATE customer SET password='$newpass' WHERE id='$id' ";
            $query_run = mysqli_query($connection, $query);

            if($query_run)
            {
                $_SESSION['status_password'] = "Password changed";
                $_SESSION['status_code'] = "success";
                session_destroy();
                unset($_SESSION['cusername']);
                header('Location: login.php');
            }
            else 
            {
                $_SESSION['status_password'] = "Password not Changed";
                $_SESSION['status_code'] = "error";
                header('Location: profile.php');  
            }
        }
        else
        {
            $_SESSION['status_password'] = "New Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: profile.php');
        }
    }
    else
    {
        $_SESSION['status_password'] = "Old password and Password Does not Match";
        $_SESSION['status_code'] = "warning";
        header('Location: profile.php');
    }


}






if(isset($_POST['paymentsubmit']))
{
    $userid = $_POST['userid'];

    $amountoPay = $_POST['balance'];
    $paymentInput = $_POST['paymentInput'];
    

    if($amountoPay === $paymentInput)
    {
        $query = "INSERT INTO invoice (customer_id, amount) VALUES ('$userid','$amountoPay')";
        $query_run = mysqli_query($connection, $query);
        $query = "DELETE FROM penalty WHERE customer_id = '$userid' ";
        $query_run = mysqli_query($connection, $query);
        
        
        if($query_run)
        {
            $_SESSION['status'] = "Transaction Complete";
            $_SESSION['status_code'] = "warning";
            header('Location: pay.php');
        }
        else
        {
            $_SESSION['status'] = "Insertion error";
            $_SESSION['status_code'] = "warning";
            header('Location: pay.php');
        }
    }
    else
    {
        $_SESSION['status'] = "Incomplete transaction";
        $_SESSION['status_code'] = "warning";
        header('Location: pay.php');
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