<?php
include_once('includes/session.php');
include_once('includes/dbcon.php');
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

if(isset($_POST['signup']))
{
    $email = test_input($_POST['signup-uname']);
    $pass = test_input($_POST['signup-pass']);
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    // check if e-mail address is well-formed
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $sql = "SELECT * FROM `users` WHERE `email` = ? ";
    $res = mysqli_prepare($dbcon,$sql);
    $res->bind_param("s", $email);
    $res->execute();
    $ans=$res->get_result();
    $res->close();
    if(mysqli_num_rows($ans)===0)
    {
        $sql = "INSERT INTO `users` (`id`, `email`, `password`) VALUES (NULL, ?, ?)";
        $stmt = mysqli_prepare($dbcon,$sql);
        $stmt->bind_param("ss", $email, $pass);
        $stmt->execute();
        if($stmt)
        {   
            $_SESSION['user']=$email;
            mkdir(dirname(__FILE__).'/data/'.$email);
            $_SESSION['error']='';
        }
        else $_SESSION['error']='unknown error unable to create user. Please try again after some time';
        $stmt->close();
    }
    else $_SESSION['error']='User already Exists Please use login Page';
    }else $_SESSION['error']="Not valid Email";
        
}
mysqli_close($dbcon);
$to_redirect='/index.php';
if(isset($_SESSION['to_redirect']))
{
    $to_redirect=$_SESSION['to_redirect'];
}
header("Location: $to_redirect");
?>