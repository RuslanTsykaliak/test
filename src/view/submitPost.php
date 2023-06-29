<!DOCTYPE html>
<html>
<head>
    <title>Submit Post</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .shorten-input {
            max-width: 350px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST">
            <div class="form-group">
                <label for="post_title">Post Title</label>
                <input type="text" class="form-control shorten-input" id="post_title" name="post_title" placeholder="Post Title" maxlength="25">
            </div>
            <div class="form-group">
                <label for="post_content">Post Content</label>
                <textarea class="form-control" id="post_content" name="post_content" placeholder="Post Content" maxlength="255" style="height: 90px;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
include '../controller/functionSubmitPost.php';
include 'footer.php';
?>
