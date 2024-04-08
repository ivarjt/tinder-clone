<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEMP</title>
</head>
<body>
    <h1>TEMPORARY</h1>
    <hr>

    <?php
    session_start();

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        echo "<p>You are logged in.</p>";
    } else {
        echo "<p>You are not logged in.</p>";
    }
    ?>

    <hr><br>
    <a href="authentication/register.php">Register</a><br>
    <a href="authentication/login.php">Login</a><br>
    <a href="authentication/logout.php">Logout</a><br>
    <a href="authentication/profile.php">Profile</a>

</body>
</html>
