<?php
    require_once('session.php');
    require_once('dbConnect.php');

    $postId = $_REQUEST['postId'];

    $query = "delete from posts where postId =?;";
    $stmt = $mysqli->stmt_init();
    if (!($stmt->prepare($query))) {
        echo "SQL failed";
    } else {
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        if ($_SESSION["isAdmin"] == 1) { 
            header("Location: ../allPosts.php?deletePost=success");
        }
        else {
            header("Location: ../myPosts.php?deletePost=success");
        }
    }
?>