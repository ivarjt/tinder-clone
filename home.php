<?php
// Start session
session_start();

// Check if logout is requested
if (isset($_GET["logout"])) {
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();

    // Redirect to login page
    header("Location: authentication/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tinder Clone - Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* CSS styles go here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
        }
        
        p {
            text-align: center;
            color: #777;
        }
        
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff6b6b;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        
        .button:hover {
            background-color: #ff4f4f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Tinder Clone</h1>
        <p>Find your perfect match!</p>
        <a href="#" class="btn btn-primary">Get Started</a>
        <?php
        // Check if user is logged in
        if (isset($_SESSION["username"])) {
            // User is logged in, display logout button
            echo '<a href="?logout" class="btn btn-primary">Logout</a>';
        } else {
            // User is not logged in, display login and register buttons
            echo '<a href="authentication/login.php" class="btn btn-primary">Login</a>';
            echo '<a href="authentication/register.php" class="btn btn-secondary">Register</a>';
        }
        ?>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
