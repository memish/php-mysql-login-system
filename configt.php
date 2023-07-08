<?php
//call to file with passowrd info. this file should be in a safe directory
require_once 'safe/config.php';

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Function to sanitize user input
function sanitizeInput($input)
{
    // Sanitize the input using appropriate sanitization techniques
    // For example, you can use mysqli_real_escape_string() or a library like filter_var()
    global $connection;
    $sanitizedInput = mysqli_real_escape_string($connection, $input);
    return $sanitizedInput;
}

// Function to hash passwords using bcrypt
function hashPassword($password)
{
    // Generate a bcrypt hashed password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    return $hashedPassword;
}

// Function to verify a password against the stored hash
function verifyPassword($password, $hashedPassword)
{
    // Verify the password against the stored hash
    $isPasswordCorrect = password_verify($password, $hashedPassword);
    return $isPasswordCorrect;
}

// Function to perform user login
function loginUser($username, $password)
{
    global $connection;

    $username = sanitizeInput($username);

    // Prepare and execute a SELECT statement to retrieve user details
    $stmt = $connection->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with the given username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $dbUsername, $dbPassword);
        $stmt->fetch();

        // Verify the provided password against the stored hash
        if (verifyPassword($password, $dbPassword)) {
            // Password is correct, return user data
            return [
                'success' => true,
                'userId' => $userId,
                'username' => $dbUsername
            ];
        }
    }

    return [
        'success' => false,
        'message' => 'Invalid username or password.'
    ];
}

// Function to register a new user
function registerUser($username, $password)
{
    global $connection;

    $username = sanitizeInput($username);
    $hashedPassword = hashPassword($password);

    // Prepare and execute an INSERT statement to create a new user
    $stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        // User registration successful
        return [
            'success' => true,
            'userId' => $stmt->insert_id,
            'username' => $username
        ];
    } else {
        // User registration failed
        return [
            'success' => false,
            'message' => 'Error creating user.'
        ];
    }
}
?>
