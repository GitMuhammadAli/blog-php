<?php
session_start();
include ('db.php');
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $details = $_POST['details'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO threads (title, details, user_id) VALUES ('$title', '$details', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        $message = "New thread created successfully";
        $message_type = "success";
        header("location: index.php");
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
    <title>Create New Thread</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Create New Thread</h1>
        <?php if (isset($message)): ?>
                    <div class="message <?php echo $message_type; ?>">
                        <?php echo $message; ?>
                    </div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="input-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="input-group">
                <label for="details">Details:</label>
                <textarea id="details" name="details" rows="5" required></textarea>
            </div>
            <div class="input-group">
                <input type="submit" value="Create Thread">
            </div>
        </form>
    </div>
</body>

</html>