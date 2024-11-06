<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'water_monitor');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = ''; // Variable to store error messages

// Registration process
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $checkUser = $conn->query("SELECT * FROM users WHERE username='$username'");
        if ($checkUser->num_rows == 0) {
            $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$hashedPassword')";
            if ($conn->query($sql) === TRUE) {
                header('Location: login.php');
                exit();
            } else {
                $error = "Error: " . $conn->error;
            }
        } else {
            $error = "Username already exists!";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="stylesback.css">
</head>
<body>

    <!-- Video background -->
    <video autoplay muted loop class="video-bg">
        <source src="bgd.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <!-- Register Form Container -->
    <div class="container">
        <h2>Register</h2>

        <!-- Display Error Message Above Form -->
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" name="register" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login Here</a></p>
    </div>

</body>
</html>
