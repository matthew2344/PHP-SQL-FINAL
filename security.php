<?php
session_start();
include('admin/database/dbconfig.php');
if($connection)
{
    // echo "Database Connected";
}
else
{
    header("Location: admin/database/dbconfig.php");
}


if(!$_SESSION['cusername'])
{
    header('Location: login.php');
}

$check_reservation = "SELECT * FROM reservation";
$check_run = mysqli_query($connection,$check_reservation);
if($check_run)
{
    while($checking = mysqli_fetch_assoc($check_run))
    {
        $id = $checking['id'];
        $date_end = date('Y-m-d H:i:s',strtotime($checking['date_end']));
        $today = date("Y-m-d H:i:s");
        
        $end = new DateTime($date_end);
        $now = new DateTime($today);

        if($now > $end)
        {
            $delete = "DELETE FROM reservation WHERE id = '$id'";
            $delete_run = mysqli_query($connection, $delete);
        }
        
    }
}

?>