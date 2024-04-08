<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is logged in
    $navbar_button = '<a class="nav-link btn btn-outline-warning" href="authentication/logout.php">Logout</a>';
    $signup_button = ''; // Empty string if user is logged in
} else {
    // User is not logged in
    $navbar_button = '<a class="nav-link btn btn-outline-primary" href="authentication/login.php">Login</a>';
    $signup_button = '<a class="nav-link btn btn-outline-success" href="authentication/register.php">Sign Up</a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(to bottom, #ff8c00, #ff1493);
        }
        .navbar {
            border-bottom: rgb(255, 255, 255) 3px solid;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .footer {
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: auto;
            width: 100%;
            border-top: rgb(255, 255, 255) 3px solid;
        }
        .social-icons {
            margin-top: 20px;
        }
        .social-icons a {
            color: white;
            margin: 0 10px;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dating Website</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <?php echo $navbar_button; ?>
                    </li>
                    <li class="nav-item">
                        <?php echo $signup_button; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1>Welcome to our Dating Website</h1>
        <p>Find your perfect match today!</p>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p>&copy; <?php echo date("Y"); ?> Dating Website</p>
        </div>
    </footer>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>