<?php
session_start();

// Check if the user is not logged in, redirect to login page if true
if (!isset($_SESSION['userId'])) {
    header("Location: logincreate.php");
    exit();
}

// Access the user's information from the session
$userId = $_SESSION['userId'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <title>Student Randomizer</title>
</head>

<body style="margin: 10px;">
   
    <div>
        <h2>Welcome, <?php echo $username; ?>!</h2>
    <p>This is the dashboard page that only authenticated users can access.</p>
    <a href="logout.php">Logout</a><br><br>
    
<br>
</div>




   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>
