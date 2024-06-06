<link rel="stylesheet" href="style.css">
<?php
include ('db.php');

?>
<header class="navbar">
  <a href="index.php" class="navbar-brand">BLogify</a>
  <nav>
    <ul class="navbar-nav">
      <li>
        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>

      </li>
      <li><a href="index.php">Home</a></li>
      <li>
        <a href="create_thread.php">ADD BLOG</a>
      </li>
      <li> <a href="logout.php">LOGOUT</a></li>
    </ul>
  </nav>
</header>


