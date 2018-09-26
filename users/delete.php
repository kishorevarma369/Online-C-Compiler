<?php
include_once(dirname(__FILE__).'/../includes/session.php');
if(!isset($_SESSION['error'])||!isset($_SESSION['user'])||$_SESSION['user']=='')
{
    header('Location: /index.php');
}
if(isset($_GET['fname']))
{
    error_reporting(0);
    unlink(dirname(__FILE__).'/../data/'.$_SESSION['user'].'/'.$_GET['fname']);
    error_reporting(-1);
}
header('Location: /users/index.php');
?>