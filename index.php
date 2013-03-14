<!DOCTYPE html>

<html lang="en">
<head>
    <title>Manny's Blogpost</title>
</head>

<body>  
    <?php
    require_once("common.php");  // creates session array(kinda like POST) that can save  variables between pages
    ?>
        <h3>Manny's Blogpost</h3>
    <?php
    if(isset($_SESSION['username'])){
        echo  " Hello " . $_SESSION['username'] . "</br>"; // use "."to concatinate in php 
    ?> 
        <a href = "post.php">make a post</a></br>
        <form name = "logout" action= "login.php" method = "post">
        <input type = "submit" name = "logoutButton" value = "Log Out"/>
        </form>
    <?php
    //bootstrap branch
    }
    
    else{
        if(isset($_SESSION['loginFail'])){
            echo $_SESSION['loginFail'] . "</br>";
            echo "login fail";
            unset($_SESSION['loginFail']);
        }
    ?>  
        <form name = "login" action= "login.php" method = "post">
        <strong>Username: </strong><input type = "text" name = "username"/></br>
        <strong>Password: </strong><input type = "password" name = "password"/></br>
        <input type = "submit" value = "Log In" />
        </form></br>
        <a href = "register.php"><strong>Register</strong></a></br>

    <?php
    }
    ?> 
</body>
</html>
