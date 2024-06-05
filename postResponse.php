<?php
session_start();
include ('db.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

function postResponse($threadId, $userId, $content)
{
  global $conn;
  $stmt = $conn->prepare("INSERT INTO posts (thread_id, user_id, content) VALUES (?, ?, ?)");
  $stmt->bind_param("iis", $threadId, $userId, $content);
  if ($stmt->execute()) {
    $postId = $stmt->insert_id;
    return $postId;
  }
  return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $threadId = $_POST['thread_id'];
  $content = $_POST['content'];
  $userId = $_SESSION['user_id'];

  if (postResponse($threadId, $userId, $content)) {
    echo "Response posted successfully.";
  } else {
    echo "Failed to post response.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Post Response</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h1>Post a Response</h1>
    <form action="postResponse.php" method="post">
      <textarea name="content" required></textarea>
      <input type="hidden" name="thread_id" value="1"> <!-- Replace with dynamic thread ID -->
      <button type="submit">Post Response</button>
    </form>
  </div>
  <?php include 'footer.php'; ?>
</body>

</html>