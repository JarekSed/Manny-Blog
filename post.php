<?php
require_once("common.php");
if(getUserName()){
?>

<h3>Manny's BlogPost</h3>
<a href = "index.php">Back to Home Page</a>
</br><form name = "postForm" action =  "viewPost.php" method = "post">
<strong>Post Title: </strong><input type = "text" name = "postTitle"/></br>
<strong>Post Body: </strong><textarea class = "input-xxlarge" rows = "10"  name = "postBody"></textarea></br>
<input type = "submit" value = "Post"/>
</form>
<?php
getPosts(); //display user posts
}else{
    echo "You are not logged in";
?>
    <a href = "index.php">Back to home</a>
<?php
}
?>
