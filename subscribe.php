<?php
session_start();
include ('db.php');

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$thread_id = $_GET['thread_id'];

$sql = "INSERT INTO subscriptions (user_id, thread_id) VALUES ('$user_id', '$thread_id')";
if ($conn->query($sql) === TRUE) {
  header("Location: view_thread.php?thread_id=$thread_id");
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
?>