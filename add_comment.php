<?php

// set or include db.php file
include 'db.php';

// Check if the request is post
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // get the data name from the comment form
    $name = stripslashes(strip_tags(htmlspecialchars($_POST["name"], ENT_QUOTES)));
    $comment = stripslashes(strip_tags(htmlspecialchars($_POST["comment"], ENT_QUOTES)));
    $parent_id = stripslashes(strip_tags(htmlspecialchars($_POST["parent_id"], ENT_QUOTES)));
    
    // set timezone 
    $date = date('Y-m-d H:i:s');

    // do insert
    $query = "INSERT INTO tbl_comment (name, comment, parent_id, comment_date) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssis", $name, $comment, $parent_id,  $date);
    $stmt->execute();
    
 // redirect HTTP/1.1 404 Not Found when the user tries to access add_comment.php file
} else {
    header("HTTP/1.1 404 Not Found");
}
?>
