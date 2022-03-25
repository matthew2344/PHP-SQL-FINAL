<?php
session_start();

if(isset($_POST['logout_btn_customer']))
{
    session_destroy();
    unset($_SESSION['cusername']);
    header('Location: login.php');
}
session_destroy();
unset($_SESSION['cusername']);
header('Location: login.php');

?>