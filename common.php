<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<link type = "text/css" rel = "stylesheet" href = "stylesheet.css"/>

<?php
require_once("database.php");
session_start();  // creates session array(kinda like POST) that can save  variables between pages

/*
returns username if user is logged in
returns false if not logged in
*/
function getUserName(){ 
    if(isset($_SESSION['username'])){
        return $_SESSION['username'];
    }else{
        return false;
    }
}

/*
returns author_id from mysql Author table if user is logged in
returns false if not logged in
*/
function getID(){      
    global $db;  
    if(!isset($_SESSION['username'])){
        return false;
        ?>
            <a href = "index.php">Not logged in. Return to home page</a> 
        <?php
    }
    $username = $_SESSION['username'];
    $command = "SELECT author_id FROM Authors WHERE username=:value";
    $stmt = $db->prepare($command); //prepare creates object from string
    $stmt->bindParam(':value', $username); // puts variable $ in placeholder : while checking for string escape bs
    if (!$stmt->execute()) {   //executes the command from the string. returns boolean
        echo "Database is down. Screwed up the command";
        exit;
    }
    $results = $stmt->fetchAll();  //returns all the results from the command
    if(count($results)==1){  //checks how many results where returned. returns 1 or 0
        return $results[0]['author_id'];     
    }else{
        return false;
    }
}
function getPosts(){
    //getting all of the users posts to display 
    if(!isset($_SESSION['username'])){
        return false;
        ?>
            <a href = "index.php">Not logged in. Return to home page</a> 
        <?php
    }
    global $db;
    $id = getID();
    $command = "SELECT content,title,date from Posts Where author_id=:value";
    $stmt = $db->prepare($command);
    $stmt->bindParam(':value', $id);
    if(!$stmt->execute()){
        echo "Screwed up command";
    }
    $results = $stmt->fetchAll();

    //prints all post title,content,date from results array starting with most recent;
    for($i = count($results)-1; $i>=0; $i--){
        echo " Title: ". $results[$i]["title"] . "/";
        echo " Content: " . $results[$i]["content"] . "/";
        echo " Date: " . $results[$i]['date'];
        echo "</br>";
    }
}
?>
