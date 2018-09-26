<?php 
include_once(dirname(__FILE__).'/../includes/session.php');
if(!isset($_SESSION['error'])||!isset($_SESSION['user'])||$_SESSION['user']=='')
{
    header('Location: /index.php');
}
include_once(dirname(__FILE__).'/../includes/dbcon.php');
if(isset($_POST['submit']))
{
    $res=mysqli_query($dbcon,"DELETE FROM USERS WHERE EMAIL='".$_SESSION['user']."';");
    if($res)
    {
        $mydir=dirname(__FILE__).'/../data/'.$_SESSION['user'];
        $_SESSION['user']='';
        mysqli_close($dbcon);
        error_reporting(0);
        rmdir($mydir);
        error_reporting(-1);
    }
}
?>