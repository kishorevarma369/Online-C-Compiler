<?php 
include_once('includes/session.php');
include_once('includes/dbcon.php');
include_once('includes/compile.php');
if(!isset($_SESSION['error'])||!isset($_SESSION['user']))
{
    $_SESSION['error']='';
    $_SESSION['user']='';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online C compiler</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.min.js"></script>
	<script src="js/jquery-linedtextarea.js"></script>
	<link href="css/jquery-linedtextarea.css" type="text/css" rel="stylesheet" />
</head>
<body>
<?php include('includes/nav.php') ?>
    <?php include('includes/ide-form.php') ?>
    <?php include_once('includes/ls-form.php'); ?>
    <script>$(function() {
	$(".code-area").linedtextarea();
});</script>
    <script src="js/mys.js"></script>
</body>
</html>
<?php
$_SESSION['error']='';
mysqli_close($dbcon)?>