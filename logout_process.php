<?php
session_start();

if(isset($_SESSION['auth']))
{
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    unset($_SESSION['role']);
    unset($_SESSION['obbsuid']);
    unset($_SESSION['login']);
    $_SESSION['message']= "Logged out successfully!";

}

header('Location: login.php');
?>
