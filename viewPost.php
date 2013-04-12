<?php
    require_once("common.php");
    $authorID = getID();
    if(!$authorID){
        echo "not logged in";
        ?>
        <a href = "index.php">Back to home</a>
        <?php
    }
?>

<h3>Manny's BlogPost</h3>
<a href = "index.php">Back to Home Page</a></br>
<?php
    if(!isset($_POST['postTitle'])|| !isset($_POST['postTitle'])){
        echo "<strong>invalid post. input into both fields</strong></br>";
        echo  '<a href = "post.php">Make another post</a></br>';
    }else{
        $postTitle = $_POST['postTitle'];
        $postBody = $_POST['postBody'];
        unset($_POST['postTitle']);
        unset($_POST['postBOdy']);
       $command = "INSERT INTO Posts (title, content, author_id) VALUES(:title, :content, :author_id)";
       $stmt = $db->prepare($command);
       $stmt->bindParam(':title', $postTitle);
       $stmt->bindParam(':content', $postBody);
       $stmt->bindParam('author_id', $authorID);
       if(!$stmt->execute()){
            echo "screwed up mysql command";
       }else{
            echo "Post Made! </br>";
            getPosts();
            ?>
            <a href = "post.php">Make another post</a></br>
            <?php
       }
    } 

?>
