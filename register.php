<?php
    require_once("common.php");
    if(getUserName()){
        echo "</br> You are already logged into an account. Log out to register for a new one.";
        ?>          
        </br><a href="index.php">Go back to home page</a>

        <?php
    }else{
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
        /*
        inputs: username(string) and local database(string)
        returns true if username is not already in Authors table
        returns false is username is taken
        */
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
        /*
        inputs: username(string), hashed password(string), local database(string)
        returns true if mysql statement  is successfully executed, username and hasword stored into table
        returns false if mysql statement is invalid or if database is down
        */
        function registerUser($username, $hashword, $db){ 
            $command = "INSERT INTO Authors (username, hash) VALUES(:username, :hashword)"; // :variable acts as placeholder for $variable
            $stmt = $db->prepare($command);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':hashword', $hashword);
            if(!$stmt->execute()){             
                return false;
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
            global $db; //calls the global database variable to be used in following code
            if(checkUsername($username, $db)){
                if(!registerUser($username, $hashword, $db)){
                    echo "Database is down or invalid mysql command";
                    exit;
                }
                echo "Registration Succesful";
            }else{
                echo "Cannot register with a taken username";
                exit;
            }
            ?>
            <a href = "index.php">Back to home</a>
            <?php

        }
    }
?>
