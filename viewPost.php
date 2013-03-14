<?php
    require_once("common.php");
    $authorID = getID();
    if(!$authorID){
        echo "not logged in";
        ?>
        <a href = "index.php">Back to home</a>
        <?php
    }
    if(!isset($_POST['postTitle']) || !isset($_POST['postBody'])){
        echo "invalid post. input into both fields";
    }else{
        $postTitle = $_POST['postTitle'];
        $postBody = $_POST['postBody'];
    }
       $command = "INSERt INTO Posts (title, content, author_id) VALUES(:title, :content, :author_id)";
       $stmt = $db->prepare($command);
       $stmt->bindParam(':title', $postTitle);
       $stmt->bindParam(':content', $postBody);
       $stmt->bindParam('author_id', $authorID);
       if(!$stmt->execute()){
            echo "screwed up command";
       }else{
            echo "Post Made! </br>";
            ?>
            <a href = "post.php">Make another post</a></br>
            <a href = "index.php">Return to home page</a></br>
            <?php
       }
     

?>
