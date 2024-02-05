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
        /* Custom CSS styles */
        body {
            background-color: #fff;
            font-family: Arial, sans-serif;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px 20px;
            text-align: center;
        }
        
        .heading {
            color: #333;
            font-size: 36px;
            margin-bottom: 30px;
        }
        
        .sub-heading {
            color: #777;
            font-size: 18px;
            margin-bottom: 40px;
        }
        
        .btn-get-started {
            padding: 12px 30px;
            font-size: 18px;
            background-color: #ff6b6b;
            border: none;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        
        .btn-get-started:hover {
            background-color: #ff4f4f;
        }

        .top-left {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .top-right {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        /* CSS styles from the first snippet */
        .profile {
            text-align: center;
        }

        .profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-top: -10px;
            left: 10px;
            position: absolute;
        }

        .actions {
            text-align: center;
        }

        .hidden {
            display: none;
        }

        #discover {
            text-align: center;
            margin-top: 20px;
        }

        #discover button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="top-left">
        <!-- HTML structure for profile and discovery -->
        <div class="profile">
            <img src="static/matrix.jpg" alt="Profile Image">
            <h3>My Profile</h3>
        </div>
        <div class="actions">
            <h3>Discover New Matches</h3>
            <p>Start swiping to connect with new people!</p>
            <div id="discover">
                <button id="swipe">Swipe</button>
            </div>
        </div>
    </div>

    <div class="container">
        <h1 class="heading">Welcome to Tinder Clone</h1>
        <p class="sub-heading">Find your perfect match!</p>
        <a href="#" class="btn btn-get-started">Get Started</a>
    </div>

    <div class="top-right">
        <?php
        // Check if user is logged in
        if (isset($_SESSION["username"])) {
            // User is logged in, display logout button
            echo '<a href="?logout" class="btn btn-primary">Logout</a>';
        } else {
            // User is not logged in, display login and register buttons
            echo '<a href="authentication/login.php" class="btn btn-primary">Login</a>';
            echo '<a href="authentication/register.php" class="btn btn-secondary ml-2">Register</a>';
        }
        ?>
    </div>

</body>
</html>
