<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="http://code.jquery.com/jquery.js"></script>
<script  type = "text/javascript" src = "script.js"></script>
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
/*
prints all posts from user
*/
function getPosts(){
    if(!isset($_SESSION['username'])){
        return false;
        ?>
            <a href = "index.php">Not logged in. Return to home page</a> 
        <?php
    }
    global $db;
    $id = getID();
    $command = "SELECT content,title,date from Posts Where author_id=:value"; //gets posts, title and date from user
    $stmt = $db->prepare($command);
    $stmt->bindParam(':value', $id);
    if(!$stmt->execute()){
        echo "Screwed up command";
    }
    $results = $stmt->fetchAll(); // puts output in array

    /*prints all post title,content,date from results array starting with most recent;
    divides all posts into collapsable divs
    */
    for($i = count($results)-1; $i>=0; $i--){
        ?><div class = "posts"><?php
        echo " <span id = 'author'>Author: " . getUserName() . "</span></br>";
        echo " <span id = 'title'>Title: ". $results[$i]["title"] . "</span></br>";
        echo " <span id = 'date'>Date: " . $results[$i]['date'] . "</span></br>";
        ?><span id = 'hidden'><?php
        echo $results[$i]["content"]?>
        </span>
        </div>
        </br>
        <?php
        
    }
}
?>
