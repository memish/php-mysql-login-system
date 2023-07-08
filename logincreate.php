<?php
session_start();
//this connects to file that creates a connection to your database
require_once 'configt.php';

// Check if the user is already logged in, redirect to dashboard if true
if (isset($_SESSION['userId'])) {
    header("Location: index.php");
    exit();
}

// Handle the login form submission
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform the login process
    $result = loginUser($username, $password);

    if ($result['success']) {
        // Login successful, store user data in session
        $_SESSION['userId'] = $result['userId'];
        $_SESSION['username'] = $result['username'];
       $mess = "yes, well done";
        header("Location: index.php");
        exit();
    } else {
        // Login failed, display an error message
        $errorMessage = $result['message'];
         $mess = "crap, that didn't work";
        echo("Something went wrong in your login process");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
      <p>
    <?php 
      echo( "Message". $mess); //this should be removed. just for testing
      ?>
      </p>
    <?php if (isset($errorMessage)) ?>
        <p><?php echo $errorMessage; ?></p>
 
    <form method="POST" action="logincreate.php">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>

