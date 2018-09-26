<?php
include_once(dirname(__FILE__).'/includes/session.php');
if(isset($_SESSION['user']))
{
    $_SESSION['user']='';
    $_SESSION['error']='';
}
$to_redirect='/index.php';
header("Location: $to_redirect");
?>