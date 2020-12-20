<?php
    require_once('session.php');
    require_once('dbConnect.php');

    //not sure
    $commentId = $_REQUEST['commentId'];
    $query = "delete from comments where commentId =?;";
    $stmt = $mysqli->stmt_init();
    if (!($stmt->prepare($query))) {
        echo "SQL failed";
    } else {
        $stmt->bind_param('i', $commentId);
        $stmt->execute();
        header("Location: ../readPost.php?postId=".$_REQUEST['postId']);  
    }
?>



