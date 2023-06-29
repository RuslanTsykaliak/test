<?php
include '../model/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['creatorId']) && isset($_POST['postId'])) {
    $creatorId = $_POST['creatorId'];
    $postId = $_POST['postId'];

    $sql = "SELECT * FROM posts WHERE id = '$postId' AND creator_id = '$creatorId'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $deleteSql = "DELETE FROM posts WHERE id = '$postId' AND creator_id = '$creatorId'";
        if ($conn->query($deleteSql) === TRUE) {
            echo "success";
        } else {
            echo "Error deleting post: " . $conn->error;
        }
    } else {
        echo "Unauthorized access or post not found";
    }
} else {
    echo "Invalid request";
}
?>
