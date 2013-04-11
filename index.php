<!DOCTYPE html>

<html lang="en">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<head>
    <title>Manny's Blogpost</title>
</head>
<body>  
    <?php
    require_once("common.php"); 
    ?>
    <h3>Manny's BlogPost</h3>
    <?php
    if(isset($_SESSION['username'])){  //home page if user is logged in
        echo  " Hello " . $_SESSION['username'] . "</br>"; // use "."to concatinate in php 
    ?> 
        <a href = "post.php">make a post</a></br>
        </br>
        <?php
           getPosts();

        ?>
        <form name = "logout" action= "login.php" method = "post">
        <input type = "submit" name = "logoutButton" value = "Log Out"/>
        </form>
    <?php
    }
    
    else{    //if user inputs invalid login information
        if(isset($_SESSION['loginFail'])){
            echo $_SESSION['loginFail'] . "</br>";
            echo "login fail";
            unset($_SESSION['loginFail']);
        }
        //default home page
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
