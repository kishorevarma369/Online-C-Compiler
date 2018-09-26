<?php
include_once(dirname(__FILE__).'/../includes/session.php');
if(isset($_SESSION['user']))
{
    unset($_SESSION['user']);
}
header('Location: /index.php');
?>