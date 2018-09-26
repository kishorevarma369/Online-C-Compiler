<?php 
include_once(dirname(__FILE__).'/../includes/session.php');
if(!isset($_SESSION['error'])||!isset($_SESSION['user']))
{
    $_SESSION['error']='';
    $_SESSION['user']='';
}
$uname='';
$fname='';
$res='';

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

if(isset($_GET['uname']))
{
    $uname=$_GET['uname'];
    if(!is_valid_uname($uname)){
        $_SESSION['error'] = 'Not a valid user name';
        header('Location: /index.php');
    } 
    if(isset($_GET['fname']))
    {
        $fname=$_GET['fname'];
        $fname=dirname(__FILE__).'/../data/'.$uname.'/'.$fname;
        error_reporting(0);
        $filehandle=fopen($fname,'r');
        if($filehandle==null)
        {
            $_SESSION['error']='No Such File exists';
            header('Location: /users/index.php?uname='.$uname);
        }
        $fsize=filesize($fname);
        if($fsize>0)
        {
            $res=fread($filehandle,$fsize);
        }
        fclose($filehandle);
        error_reporting(-1);
    }
    else
    {
        header('Location: /users/index.php?uname='.$uname);
    }
} 
else
{
    $_SESSION['error']='You Tried To access a user page which doesnt exist';
    header('Location: /index.php');
}
$_SESSION['to_redirect']= "/users/view.php?uname=$uname&fname=".$_GET['fname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online C compiler</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="/css/atom-one-dark.css">
    <script src="/js/highlight.pack.js"></script>
    <script src="../js/jquery.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <style>
        .view-area{
            width:70%;
            margin:0 15%;
            margin-top:5%;
            background:rgba(0,0,0,0.85);
            color:white;
            padding:5% 0 1% 0;
        }
        .cpp{
            background:none !important;
        }
        .options{
            padding:1%;
            display:inline-block;
        }
    </style>
</head>
<body>
    <?php include(dirname(__FILE__).'/../includes/nav.php') ?>
    <div class="error"></div>
    <div class="view-area myswitch" >
    <h1 align="center"><?php echo $_GET['fname']; ?></h1>
    <br><br>
    <hr>
    <?php 
    $myfile=$_GET['fname'];
    echo "<div align=\"center\"><a class=\"options\" href='edit.php?uname=$uname&fname=$myfile'>Edit</a>";
    if($uname==$_SESSION['user']&&$uname!='')
    {
        echo "<a class=\"options\" href='delete.php?fname=$myfile'>Delete</a>";
    }
    echo '</div>';
    ?>
    <br><br>
    <pre>
    <code class="cpp">
<?php echo str_replace("<","&lt;",str_replace(">","&gt;",$res)); ?>
</code>
    </pre>
    </div>
    <?php if($_SESSION['user']=='') include(dirname(__FILE__).'/../includes/ls-form.php') ; ?>
    <script src="../js/mys.js"></script>
</body>
</html>
