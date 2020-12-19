<?php
    require_once('incl/session.php');
    include('incl/addPost.incl.php');
?>

<html>
<head>
    <title>Add a post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style/addPost.css">
    <script src="incl/formValidation.js"></script>
</head>

<body>
    <?php
        require_once('navbar.php');
    ?>
    <div class="container">
        <h1>Add your post here!</h1>
        <h2>Geralt would love to hear your opinion!</h2>
        <form action="<?php $_SERVER['PHP_SELF'];?>" class="needs-validation" novalidate method="POST" enctype='multipart/form-data' >
            <div class="row mb-3">
                <label for="input" class="col-sm-2 col-form-label">Heading</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="name" name="postName" required value="<?php echo $postName; ?>">
                    <div class="invalid-feedback">
                       Please choose a heading.
                    </div>
                </div>  
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Text</label>
                <div class="col-sm-10">
                    <textarea class="form-control" required id="text" rows="10" name="postText" value="<?php echo $postText; ?>"></textarea>
                    <div class="invalid-feedback">
                       Please write a text.
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <label for="formFile" class="col-sm-2 col-form-label">Upload a photo</label>
                <div class="col-sm-10">
                    <input class="form-control" type="file" id="photo" name="uploadfile" required value="<?php echo $postImage; ?>">
                    <div class="invalid-feedback">
                       Please add a photo.
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary" name="Post" value="Post">Post</button>
        </form>
    </div>
</body>
</html>
