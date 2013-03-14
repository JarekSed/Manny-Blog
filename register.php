<?php
    require_once("common.php");
?>

<h3>Manny's Blogpost</h3>
<h4>Registration Form</h4>
<form name = "register" action= "register.php" method = "post">
    <strong>Username: </strong><input type = "text" name = "username"/><br/>
    <strong>Password: </strong><input type = "password" name = "password1"/><br/>
    <strong>Repeat Password: </strong><input type = "password" name = "password2"/>
    <input type = "submit" value = "Register" />
</form>
<a href ="index.php">return to home page</a>

<?php
function checkUsername($username, $db){
   
    
    $command = "SELECT username FROM Authors WHERE username=:value"; //string for the command that stmt will execute
    $stmt = $db->prepare($command); //prepare creates object from string
    $stmt->bindParam(':value', $username); // puts variable $ in placeholder : while checking for string escape bs
    if (!$stmt->execute()) {   //executes the command from the string. returns boolean
        echo "Database is down. Screwed up the command";
        exit;
    }
    $results = $stmt->fetchAll();  //returns all the results from the command
    if(count($results)==0){  //checks how many results where returned. returns 1 or 0
        return true;     
    }else{
        return false;
    }

}
function registerUser($username, $hashword, $db){
    $command = "INSERT INTO Authors (username, hash) VALUES(:username, :hashword)"; // :variable acts as placeholder for $variable
    $stmt = $db->prepare($command);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':hashword', $hashword);
    if(!$stmt->execute()){             
        echo "Database is down. Screwed up register command <br/>"; // if connection is down or syntax in command is wrong
        echo $command;
        exit;
    }
    return true;
}

if(isset($_POST["username"]) && isset($_POST["password1"]) && isset($_POST["password2"])){
    $username = $_POST["username"];
    $password1 = $_POST["password1"];
    $password2 =  $_POST["password2"];
    
    if($password1 != $password2){
        echo "Your passwords do not match. Try again";
        exit;
    }
    $hashword = md5($password1); // hashes password
    global $db;
    if(checkUsername($username, $db)){
        registerUser($username, $hashword, $db);
        echo "Registration Succesful";
        ?>
        <a href = "index.php">Back to home</a>
        <?php


    }else{
        echo "Cannot register with a taken username";
        exit;
    }
}
?>
