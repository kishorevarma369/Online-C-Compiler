<div class="nav">
        <h1 class="site"><a href="/">Online C Compiler</a></h1>
        <ul class="nav-menu">
            <?php 
            if($_SESSION['user']=='')
            {
              echo '<li><a id="login-link">Login</a></li>
              <li><a id="signup-link">Signup</a></li>
              <li><a href="#">About</a></li>';
            }
            else
            {
                echo '<li><a href="logout.php">Logout</a></li>';
                echo '<li><a href="/users/index.php?uname='.$_SESSION['user'].'">My Account</a></li>';
                echo '<li><a href="#">About</a></li>';                
            }
            ?>
        </ul>
        <div class="clear-both"></div>
</div>