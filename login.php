<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'water_monitor');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ''; // Variable to store error messages

// Login process
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "User not found!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="stylesback.css">
</head>
<body>

    <!-- Video background -->
    <video autoplay muted loop class="video-bg">
        <source src="bgd.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Login Form Container -->
    <div class="container">
        <h2>Login</h2>

        <!-- Display Error Message Above Form -->
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register Here</a></p>
    </div>

</body>
</html>
