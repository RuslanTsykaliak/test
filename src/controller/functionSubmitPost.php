<?php
include '../model/connection.php';
include '../controller/cookie.php';

$creatorId = getCreatorId();

function canMakePost($creatorId, $conn) {
    $timeLimit = time() - 600;
    $query = "SELECT COUNT(*) as count FROM authors WHERE creator_id = ? AND last_creation > FROM_UNIXTIME(?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $creatorId, $timeLimit);
    $stmt->execute();
    $stmt->bind_result($postCount);
    $stmt->fetch();
    $stmt->close();
    if (isset($postCount)) {
        return ($postCount < 1);
    }
        
    // error in cPanel
    // $result = $stmt->get_result();
    // if ($result) {
    //     $row = $result->fetch_assoc();
    //     $postCount = $row['count'];
    //     return ($postCount < 1); }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postTitle = $_POST['post_title'];
    $postContent = $_POST['post_content'];

    if (strlen($postContent) > 255) {
        echo "<div id='notification-message' class='notification-message'>
        <h3>Notification: The maximum post size is set to 255 characters.</h3>
        </div>";
    } else {
        // check if a post can be made
        if (canMakePost($creatorId, $conn)) {
            $query = "INSERT INTO posts (title, content, creator_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $postTitle, $postContent, $creatorId);
            $stmt->execute();

            // insert or update date
            $query2 = "INSERT INTO authors (creator_id, last_creation) VALUES (?, NOW()) 
           ON DUPLICATE KEY UPDATE last_creation = IF(creator_id = VALUES(creator_id), NOW(), last_creation)";
           $stmt2 = $conn->prepare($query2);
           $stmt2->bind_param("s", $creatorId);
           $stmt2->execute();

           if ($stmt->affected_rows > 0) {
                echo "<script>window.location.href = '/view/postsList.php';</script>";
            exit();
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "<div id='notification-message' class='notification-message'>
            <h3>Notification: You can only make one post every 10 minutes.</h3>
            </div>";
        }
    }
}
// docker give an error: prepare(); query();
?>

<style>
    .notification-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#notification-message').fadeIn();
        setTimeout(function() {
            $('#notification-message').fadeOut();
        }, 10000);
    });
</script>
