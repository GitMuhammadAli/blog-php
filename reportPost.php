<?php
session_start();
include ('db.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$post_id = $_GET['post_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $reason = $_POST['reason'];
  $user_id = $_SESSION['user_id'];

  $sql = "INSERT INTO reports (post_id, user_id, reason) VALUES ('$post_id', '$user_id', '$reason')";
  if ($conn->query($sql) === TRUE) {
    $message = "Report submitted successfully";
    $message_type = "success";
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
  <title>Report Post</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>
  <div class="container">
    <h1>Report Post</h1>
    <?php if (isset($message)): ?>
      <div class="message <?php echo $message_type; ?>">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>
    <form method="post" action="">
      <div class="input-group">
        <label for="reason">Reason:</label>
        <textarea id="reason" name="reason" rows="5" required></textarea>
      </div>
      <div class="button-container">
        <input type="submit" value="Submit Report">

      </div>
      <div class="reply-link">

        <a href="index.php">Back to Home</a>
      </div>
    </form>
  </div>
</body>

</html>