<?php
session_start();
include ('db.php');
include ('header.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$thread_id = $_GET['thread_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO posts (thread_id, user_id, content) VALUES ('$thread_id', '$user_id', '$content')";
    if ($conn->query($sql) === TRUE) {
        // Send notifications to subscribers
        $post_id = $conn->insert_id;
        $sql_subscribers = "SELECT user_id FROM subscriptions WHERE thread_id='$thread_id'";
        $subscribers = $conn->query($sql_subscribers);

        while ($subscriber = $subscribers->fetch_assoc()) {
            $subscriber_id = $subscriber['user_id'];
            $notification_message = "New reply in thread " . htmlspecialchars($thread['title']);
            $sql_notification = "INSERT INTO notifications (user_id, thread_id, post_id, message) VALUES ('$subscriber_id', '$thread_id', '$post_id', '$notification_message')";
            $conn->query($sql_notification);
        }

        header("Location: view_thread.php?thread_id=$thread_id");
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        $message_type = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Reply</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Post a Reply</h1>
        <?php if (isset($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="input-group">
                <label for="content">Reply:</label>
                <textarea id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="button-container">
                <input type="submit" value="Post Reply">
            </div>
        </form>
    </div>
  <?php include 'footer.php'; ?>

</body>

</html>