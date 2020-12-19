<?php
    require_once('session.php');
    require_once('dbConnect.php');

    $userId = $postName = $postText = $postImage = $tempname = $file = $postDate = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $userId = $_SESSION['id'];
        $postName = test_input($_POST['postName']);
        $postText = test_input($_POST['postText']);
        $postImage = $_FILES["uploadfile"]["name"]; 
        $tempname = $_FILES["uploadfile"]["tmp_name"];     
        $file = "../img/$postImage";
        $postDate = date("Y-m-d"); 

        $addQuery = "INSERT INTO posts (userId, postName, postText, postImage, postDate) VALUES ( ?, ?, ?, ?, ?)";
        $stmt = $mysqli->stmt_init();        
        if (!($stmt->prepare($addQuery))) {
            echo "SQL failed";
        } else {
            $stmt->bind_param('issss', $userId, $postName, $postText, $postImage, $postDate);
            $stmt->execute();
            header("Location: myPosts.php?post=success");
        }
        $stmt->close();
    }


    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>