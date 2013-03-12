


<form name = "login" action= "login.php" method = "post">
Username: <input type = "text" name = "username"/></br>
Password: <input type = "password" name = "password"/></br>
<input type = "submit" value = "Login" />
</form>
<a href = "register.php"><strong>Register</strong></a>

<?php
    session_start();  // creates session array(kinda like POST) that can save  variables between pages
    if(isset($_SESSION['username'])){
        echo  " Hello " . $_SESSION['username']; // use "." 
?>
