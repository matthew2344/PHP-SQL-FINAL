<?php
include('security.php');
$cuser = "customer";


if(isset($_POST['login_btn_client']))
{
    $email_login = $_POST['emaill']; 
    $password_login = $_POST['passwordd']; 

    $query = "SELECT * FROM $cuser WHERE email='$email_login' AND password='$password_login' LIMIT 1";
    $query_run = mysqli_query($connection, $query);


   if(mysqli_fetch_array($query_run))
   {
        if(!empty($_POST['remember']))
        {
          setcookie('email',$email_login, time()+60*60*7);
          setcookie('password',$password_login, time()+60*60*7);
        }
        else
        {
          setcookie('email',"");
          setcookie('password',"");
        }
        $_SESSION['cusername'] = $email_login;
        header('Location: index.php');
   }
   else
   {
        $_SESSION['status'] = "Email / Password is Invalid";
        header('Location: login.php');
   }
    
}


?>