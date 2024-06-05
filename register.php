<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-container">
        <h2>BLOGIFY-Registration</h2>
        <?php
        session_start();
        include ('db.php');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            $check_sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
            $check_result = $conn->query($check_sql);
            if ($check_result->num_rows > 0) {
                $error = "Username or email already exists";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert_sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
                if ($conn->query($insert_sql) === TRUE) {
                    echo "<p style='color:green;'>Registration successful. Please <a href='login.php'>login</a>.</p>";
                    header("location: login.php");
                } else {
                    $error = "Error: " . $insert_sql . "<br>" . $conn->error;
                }
            }

        }
        ?>
        <form method="post" action="">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <button type="submit">Register</button>
        </form>
        <?php if (isset($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
</body>
</html>
