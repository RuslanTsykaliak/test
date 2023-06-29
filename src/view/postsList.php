<?php
include 'header.php';
include '../model/connection.php'; //docker
include '../controller/cookie.php';


class PostsList
{
    private $creatorId;

    public function __construct($conn) {
        $this->creatorId = getCreatorId();
    }

    public function displayPosts($conn) {
        $sql = "SELECT * FROM posts ORDER BY date_of_creation DESC";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $this->displayPost($row);
            }
        } else {
            echo "No posts found";
        }
    }

    private function displayPost($row) {
        echo '<div class="post" data-post-id="' . $row['id'] . '">';
        echo "<h3>{$row['title']}</h3>";
        echo "<p>{$row['content']}</p>";
        echo "<p>Created on: {$row['date_of_creation']}</p>";

        if ($this->creatorId === $row['creator_id']) {
            echo "<button class='delete-button' data-post-id='{$row['id']}' data-creator-id='{$row['creator_id']}'>Delete</button>";
        }

        echo "</div>";
        echo "<hr>";
    }
}

$postsList = new PostsList($conn);
$postsList->displayPosts($conn);
?>

<div id="delete-success-message" class="delete-success-message">
    <h3>The post was successfully deleted</h3>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete-button').click(function() {
            const postId = $(this).data('post-id');
            const creatorId = $(this).data('creator-id');

            $.ajax({
                url: '../controller/deletePost.php',
                method: 'POST',
                data: { postId: postId, creatorId: creatorId },
                success: function(response) {
                    if (response === 'success') {
                        $('#delete-success-message').fadeIn();
                        setTimeout(function() {
                            $('#delete-success-message').fadeOut();
                        }, 2000);
                        $('.post[data-post-id="' + postId + '"]').remove();
                    } else {
                        alert('Error occurred while deleting the post');
                    }
                },
                error: function() {
                    alert('Error occurred while deleting the post');
                }
            });
        });
    });
</script>

<?php include 'footer.php'; ?>
