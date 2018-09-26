<?php 
include_once(dirname(__FILE__).'/../includes/session.php');
if(!isset($_SESSION['error'])||!isset($_SESSION['user']))
{
    $_SESSION['error']='';
    $_SESSION['user']='';
}
$uname='';
if($_SESSION['user']!='') $uname=$_SESSION['user'];
if(isset($_GET['uname'])) $uname=$_GET['uname'];
else if($uname=='') header('Location: /index.php?uname='.$uname);

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

function all_files($user)
{
    $directory = '../data/'.$user;
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    return $scanned_directory;
}

if(!is_valid_uname($uname))
{
    $_SESSION['error']='User Doesnt Exist';
    header('Location: /index.php');
} 

$user_files = all_files($uname);
$len=count($user_files);
$flag=($_SESSION['user']==$uname);
$_SESSION['to_redirect']="/users/index.php?uname=$uname";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Online C compiler</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .user-profile{
            width:70%;
            margin:0 15%;
            color:white;
            padding:5% 0 1% 0;
        }
        h2{
            font-weight:100;
        }
        .container{
            padding:5%;
        }
        .myback{
            background:rgba(0,0,0,0.5);
            padding-top:5%;
        }
        table{
            background:rgba(0,0,0,0.5);
            border-collapse: collapse;
            width:100%;
        }
        th,td{
            padding:15px;
            text-align:center;
        }
        th{
            color:#f48042;
        }
        .files{
            background:rgba(0,0,0,0.5);
            padding:5%;
            text-align:center;
        }
        .user-options a{
            padding:1%;
            display:inline-block;
        }
        #change_pass{
            display:none;
        }
    </style>
    <script src="../js/jquery.min.js"></script>
    <script>
        function delete_user()
        {
            if(confirm("Are you sure you want to delete"))
            {
                $.post('delete-user.php',{submit:'submit'},function(data){
                    location.reload();
                });
                
            }
            
        }
        function change_password()
        {
            let pblock=$('#change_pass');
            pblock.css('display','block');
            pblock.find('button').click(function(){
                let val=pblock.find('input')[0].value;
                $.post('change.php',{submit:'submit',new_pass:val},function(data){
                    location.reload();
                });
            });
        }
    </script>
</head>
<body>
    <?php include(dirname(__FILE__).'/../includes/nav.php') ?>
    <div class="user-profile myswitch">
        <div class="my-back error" style="color:white;padding:1%;">
            <?php echo $_SESSION['error'];?>
        </div>
        <div align="center" class="myback">
            <h1>USER : <?php echo $uname; ?></h1> 
            <br><br>
            <?php
            if($flag)
            {
                echo '<div class="user-options">';
                echo '<a onclick="change_password(); return false;">Change Password</a>';
                echo '<a onclick="delete_user(); return false;">Delete Account</a>';
                echo '</div>';
                echo '<div id="change_pass">
                        <input type="password">
                        <button>Change Password</button>
                    </div>';
                    
            }
        ?>
        </div>
        <div class="container">
            <h2>Saved Files:</h2>
            <br><br><br>
            <?php 
                if($len>0)
                {
                    echo '<div><table align="center">
                    <tr>
                        <th>File</th>
                        <th>View</th>
                        <th>Edit</th>';
                        if($flag) echo '
                        <th>Delete</th>';
                    echo '</tr>';
                    foreach($user_files as $myfile){
                    echo "<tr>
                            <td>$myfile</td>
                            <td><a href='view.php?uname=$uname&fname=$myfile'>Click To View</a></td>
                            <td><a href='edit.php?uname=$uname&fname=$myfile'>Click To Edit</a></td>";
                    if($flag) echo"
                            <td><a href='delete.php?fname=$myfile'>Click To Delete</a></td>";
                        
                    echo '</tr>';
                    }
                    echo '</table>';
                }
                else echo '<div class="files">No files Saved Yet';
                $_SESSION['error']='';
                ?>
            </div>
        </div>
    </div>
    <?php if($_SESSION['user']=='') include(dirname(__FILE__).'/../includes/ls-form.php') ; ?>
    <script src="../js/mys.js"></script>
</body>
</html>
