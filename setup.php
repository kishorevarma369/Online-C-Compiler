<?php
$msg='';
function writedb($a,$b,$c,$d)
{
    $ip=fopen('includes/db.php','w');
    $m='<?php
$host="'.$a.'";
$dbuser="'.$b.'";
$dbpass="'.$c.'";
$dbname="'.$d.'";
?>';
fwrite($ip,$m);
fclose($ip);
}
if(isset($_POST['submit']))
{
    
    $host=$_POST['host'];
    $dbname=$_POST['dbname'];
    $dbuser=$_POST['uname'];
    $dbpass=$_POST['password'];
    $dbcon=mysqli_connect($host,$dbuser,$dbpass);
    if (mysqli_connect_errno()) {
        $msg=mysqli_connect_error();
    }
    else{
        $db=mysqli_select_db($dbcon,$dbname);
        $sql = "CREATE DATABASE `$dbname` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
        if($db)
        {
            if (mysqli_query($dbcon, "DROP DATABASE $dbname")) {
            } else {
              $msg = "Error deleting Databse : " . mysqli_error($conn);
            }
        }
        $db=mysqli_select_db($dbcon,$dbname);
        if($dbcon->query($sql) === TRUE) {
                $sql="CREATE TABLE `$dbname`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";
                if (mysqli_query($dbcon, $sql)) {
                    $msg='Database '.$dbname.' successfully created';
                    writedb($host,$dbuser,$dbpass,$dbname);
                    mkdir("data/");
                    header('Location: index.php');
                } else {
                  $msg = "Error creating Tables : " . mysqli_error($conn);
                }
        }
        else
        {
               $msg='Error: '. $conn->error;
        }
    }
    
    
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
</head>
<body>
    <div align="center">
        <h1>Setting up C Compiler</h1>
        <h2><?php echo $msg;?></h2>
        <br><br><br><br><br><br>
        <form action="setup.php" method="post" align="center">
            <label for="host">Host Name</label>
            <input type="text" id="host" name="host">
            <br><br><br><br><br><br>
            <label for="dbname">Database Name</label>
            <input type="text" id="dbname" name="dbname">
            <br><br><br><br><br><br>
            <label for="uname">User Name</label>
            <input type="text" id="uname" name="uname">
            <br><br><br><br><br><br>
            <label for="password">Password</label>
            <input type="text" id="password" name="password">
            <br><br><br><br><br><br>
            <input type="submit" value="submit" name="submit">  
            <br><br><br><br><br><br>
            <br><br><br><br><br><br>
        </form>
    </div>
    <style>
        label{
            background:none;
        }
    </style>
</body>
</html>