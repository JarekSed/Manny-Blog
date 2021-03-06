<?php
    require_once("common.php");
    if(!isset($_POST["username"])){ //redirects to index if user visits page without loggin in through index
        header("Location: http://jsedlacek.info/~mjl288/Manny-Blog/index.php"); 
    }
    if(isset($_POST["logoutButton"])){//logs user out, redirects to index
        unset($_SESSION["username"]);
        unset($_SESSION['loginFail']);
        unset($_POST['logoutButton']);
        header("Location: http://jsedlacek.info/~mjl288/Manny-Blog/index.php");
    }else{   // logs user in with input given from the login post form

        $command = "SELECT username FROM Authors WHERE username=:value AND hash=:hashword"; //string for the command that stmt will execute
        $stmt = $db->prepare($command); //prepare creates object from string
        $stmt->bindParam(':value', $_POST["username"]);
        $stmt->bindParam(':hashword', md5($_POST["password"])); // md5 hashes password
        echo md5($_POST["password"]);
        if (!$stmt->execute()) {   //executes the command from the string. returns boolean
            echo "Database is down. Try again later";
            exit;
        }
        $results = $stmt->fetchAll();  //returns all the results from the command
        if(count($results)==1){  //checks how many results where returned
            $_SESSION['username'] = $_POST['username'];
        }else{
            $_SESSION['loginFail'] = "Incorrect login information"; // in index.php if user isnt login and loginFail is set, print message and unset
        }
        header("Location: http://jsedlacek.info/~mjl288/Manny-Blog/index.php");
    }
?> 
