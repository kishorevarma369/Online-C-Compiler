<?php 
include_once(dirname(__FILE__).'/../includes/session.php');
if(!isset($_SESSION['error'])||!isset($_SESSION['user'])||$_SESSION['user']=='')
{
    header('Location: /index.php');
}
include_once(dirname(__FILE__).'/../includes/dbcon.php');
if(isset($_POST['submit']))
{
    $pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);
    $res=mysqli_query($dbcon,"UPDATE `users` SET `password` = '$pass' WHERE EMAIL='".$_SESSION['user']."';");
    if($res)
    {
        mysqli_close($dbcon);
    }
    else $_SESSION['error']='unable to update password';
}
?>