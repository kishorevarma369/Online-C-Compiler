<?php
include_once(dirname(__FILE__).'/../includes/session.php');
include_once(dirname(__FILE__).'/../includes/functions.php');
if(!isset($_SESSION['error'])||!isset($_SESSION['user']))
{
    $_SESSION['user']='';
    $_SESSION['error']='';
}
$uname='';
function is_valid_uname($user)
{
    include(dirname(__FILE__).'/../includes/dbcon.php');
    $sql = "SELECT * FROM `users` WHERE `email` = ? ";
    $stmt = mysqli_prepare($dbcon,$sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $ans=$stmt->get_result();
    $stmt->close();
    if(mysqli_num_rows($ans)==1) $val=true;
    else $val=false;   
    mysqli_close($dbcon);
    return $val;
}
if($_SESSION['user']!='') $uname=$_SESSION['user'];
if(isset($_GET['uname']))
{
    $uname=$_GET['uname'];
    if(!is_valid_uname($uname))
    {
        $_SESSION['error']='Invalid user name';
        header('Location: /index.php');
    }
    if(isset($_GET['fname']))
    {
        //error_reporting(0);
        $fname=get_base_name($_GET['fname']).'.c';
        $fp=fopen(dirname(__FILE__)."/../data/$uname/$fname","r");
        //error_reporting(-1);
        if($fp==null)
        {
            $_SESSION['error']='No such File Exists';
            header('Location: /users/index.php?uname='.$uname);
        }
        $le=filesize(dirname(__FILE__)."/../data/$uname/$fname");
        if($le>0)
        {
            $edit_res=fread($fp,$le);
            $_SESSION['edit']=$edit_res;
            $_SESSION['save-name']=$fname;
        }
        fclose($fp);
    }
    else header('Location: /users/index.php?uname='.$uname);
} 
header('Location: /index.php');
?>