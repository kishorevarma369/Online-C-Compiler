<?php

include(dirname(__FILE__).'/../includes/db.php');
$dbcon=mysqli_connect($host,$dbuser,$dbpass,$dbname) or header('Location: setup.php');

?>