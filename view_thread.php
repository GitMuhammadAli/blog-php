<?php
session_start();
include ('db.php');
 include 'header.php'; 

$thread_id = $_GET['thread_id'];

// Fetch thread details
$sql = "SELECT * FROM threads WHERE id='$thread_id'";
$result = $conn->query($sql);
$thread = $result->fetch_assoc();

// Fetch posts in the thread
$sql = "SELECT * FROM posts WHERE thread_id='$thread_id' ORDER BY created_at ASC";
$posts = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($thread['title']); ?></title>
    <link rel="stylesheet" href="style.css">

   
</head>

<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($thread['title']); ?></h1>
        <h2>Thread Details</h2>
        <div class="thread-details">
            <p><?php echo htmlspecialchars($thread['details']); ?></p>
        </div>
        <h2>Post replies</h2>
        <?php while ($post = $posts->fetch_assoc()):
            $user_id = $post['user_id'];
            $sql_user = "SELECT username FROM users WHERE id='$user_id'";
            $result_user = $conn->query($sql_user);
            $user = $result_user->fetch_assoc();
            ?>
                <div class="post">
                    <div class="content"><?php echo htmlspecialchars($post['content']); ?></div>
                    <div class="meta">Posted by <?php echo htmlspecialchars($user['username']); ?> on
                        <?php echo $post['created_at']; ?>
                    </div>
                    <div class="post-actions">
                        <a href="reportPost.php?post_id=<?php echo $post['id']; ?>">Report</a>
                    </div>
                </div>
        <?php endwhile; ?>
        <div class="reply-link">
            <a href="index.php">Back to Home</a>
            <a href="reply.php?thread_id=<?php echo htmlspecialchars($thread_id); ?>">Post a Reply</a>
        </div>

    </div>
  <?php include 'footer.php'; ?>

</body>

</html>