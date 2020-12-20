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
        $file = "img/$postImage";
        $postDate = date("Y-m-d"); 
        //var_dump($_FILES);
        //var_dump($tempname);

        //$imageType = 0;
        if ($tempname) {
            $imageType = exif_imagetype($tempname);
        } else {
            header("Location: invalidFile.html");
            exit();
        }
        if ($imageType == IMAGETYPE_GIF || $imageType == IMAGETYPE_JPEG || $imageType == IMAGETYPE_PNG) {
            $addQuery = "INSERT INTO posts (userId, postName, postText, postImage, postDate) VALUES ( ?, ?, ?, ?, ?)";
            $stmt = $mysqli->stmt_init();        
            if (!($stmt->prepare($addQuery))) {
                echo "SQL failed";
            } else {
                $stmt->bind_param('issss', $userId, $postName, $postText, $postImage, $postDate);
                $stmt->execute();
                move_uploaded_file($tempname, $file);
                header("Location: myPosts.php?post=success");
                exit();
            }
            $stmt->close();
        } else {
            header("Location: invalidFile.html");
            exit();
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

?>