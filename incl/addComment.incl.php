<?php
    require_once('session.php');
    require_once('dbConnect.php');

    $userId = $commentDate = $postId = $commentText = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $userId = $_SESSION['id'];
        $commentDate = date("Y-m-d"); 
        $postId = $_REQUEST['postId'];
        $commentText = test_input($_POST['commentText']);

        $comQuery = "INSERT INTO comments (userId, commentDate, postId, commentText) VALUES ( ?, ?, ?, ?);";
        $stmtCom = $mysqli->stmt_init();        
        if ($stmtCom->prepare($comQuery)) {
            $stmtCom->bind_param('isis', $userId, $commentDate, $postId, $commentText);
            $stmtCom->execute();
        } else {
            echo "SQL failed";
        }
        header("Location: readPost.php?postId=".$_REQUEST['postId']);
        $mysqli->close();
        }


    //echo $mysqli->error; 

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>