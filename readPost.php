<?php
    require_once('incl/session.php');
    require_once('incl/dbConnect.php');
    include('incl/addComment.incl.php');


    $postId = $_REQUEST['postId']; 
    //var_dump($postId);

    if (!(is_numeric($postId))) {
        header('location: oops.html');
        exit;
    } 
    $postsQuery = "select * from posts,users where userId = id and postId =?;";
    $stmtPost = $mysqli->stmt_init();
    if (!$stmtPost->prepare($postsQuery)) {
        echo "SQL failed";
    } else {
        $stmtPost->bind_param( "i", $postId);
        $stmtPost->execute();
        $postsResult = $stmtPost->get_result();
        if ($postsResult->num_rows != 1) {
            header('location: oops.html');
            exit;
        } else {
            $curPost = $postsResult->fetch_array();
        }
    }
    
    //var_dump($postsResult);

    $commentQuery = "select * from comments,users where userId = id and postId =?;";
    $stmtComment = $mysqli->stmt_init();
    if (!$stmtComment->prepare($commentQuery)) {
        echo "SQL failed";
    } else {
        $stmtComment->bind_param( "i", $postId);
        $stmtComment->execute();
        $commentResultShow = $stmtComment->get_result();  
    }

?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php echo $curPost['postName']?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/readPost.css">
</head>

<body>
    <?php
        require_once('navbar.php');
        //include('incl/addComment.incl.php');
    ?>
    <div class="container">
        <div>
            <img src="img/<?php echo $curPost['postImage']?>" class="img-fluid" alt="Responsive image">
            <h1><?php echo $curPost['postName']?></h1>
            <h5 class="text-secondary">by <?php echo $curPost['firstName']." ".$curPost['lastName']." | ".(new DateTime ($curPost['postDate']))->format('d.m.Y')?></h2>
            <br>
            <p><?php echo $curPost['postText']?></p>
            <br>
        </div>
        <div>
            <h2>Comments:</h2>
            <?php
                if (!($curComment = $commentResultShow->fetch_array())) {
                    echo "<br>";
                    echo "<h5>No comments yet!</h5>";
                } else {
                    do {
                        echo "<div class='container' id='commentContainer'>";
                        echo "<div class='comment'>";
                        echo "<p class='text-primary' id='commentHeading'>".$curComment['firstName']." ".$curComment['lastName']." | ".(new DateTime ($curComment['commentDate']))->format('d.m.Y')."<br>";
                        echo "<p id='commentText'>".$curComment['commentText']."</p>";
                        if ($_SESSION["id"] == $curComment['userId'] || $_SESSION["isAdmin"] == 1) {
                            echo "<div class='card-footer text-center'>";
                            ?>
                            <a href=<?php echo "incl/deleteComment.incl.php?commentId=".$curComment['commentId']."&postId=".$curPost['postId']?> class="card-link" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                            <?php
                            echo "</div>";
                        }
                        echo "</div>";
                        echo "</div>";
                    }
                    while ($curComment = $commentResultShow->fetch_array());
                }   
            ?>
        </div>
        <div>
            <div id="respond">
                <h3>Leave a Comment</h3>
                <form action=<?php echo "readPost.php?postId=".$curPost["postId"]?> method="post" id="commentform" class="needs-validation" novalidate>
                    <textarea class = "form-control" name="commentText" id="commentTextarea" rows="10" cols="10" tabindex="4"  required="required"></textarea>
                    <div class="invalid-feedback">
                       Please write a comment.
                      </div>
                    <button class="btn btn-primary" type="submit" value="Submit comment" id="submitButton">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>