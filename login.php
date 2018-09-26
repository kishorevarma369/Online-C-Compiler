<?php
include_once('includes/session.php');
include_once('includes/dbcon.php');
function process_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
if(isset($_POST['login']))
{
    $sql = "SELECT `password` FROM `users` WHERE `email` = ? ";
    $pass=process_input($_POST['login-pass']);
    $email = process_input($_POST['login-uname']);
    $stmt = mysqli_prepare($dbcon,$sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $ans=$stmt->get_result();
    $spass=mysqli_fetch_assoc($ans)['password'];
    if(mysqli_num_rows($ans)==1&&password_verify($pass,$spass))
    {
        $_SESSION['user']=$email;
        $_SESSION['error']='';
    }
    else
    {
        $_SESSION['error']='User Email or Password Incorrect';
    } 
    $stmt->close();
     
}
mysqli_close($dbcon);
$to_redirect='/index.php';
if(isset($_SESSION['to_redirect']))
{
    $to_redirect=$_SESSION['to_redirect'];
}
header("Location: $to_redirect");
?>