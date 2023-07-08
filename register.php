<?php
session_start();
require_once 'configt.php';
//TO DO
//make sure username is unique

// Check if the user is already logged in, redirect to dashboard if true
if (isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}

// Handle the registration form submission
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform the registration process
    $result = registerUser($username, $password);

    if ($result['success']) {
        // Registration successful, store user data in session
        $_SESSION['userId'] = $result['userId'];
        $_SESSION['username'] = $result['username'];

        header("Location: dashboard.php");
        exit();
    } else {
        // Registration failed, display an error message
        $errorMessage = $result['message'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($errorMessage)) : ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form method="POST" action="register.php">
        <input type="text" name="username" placeholder="email" required><br>
        
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="index.php">Login here</a></p>
</body>
</html>
