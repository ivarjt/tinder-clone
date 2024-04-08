<?php
session_start(); // Start session

include('../db.php'); // Include the database connection file

// Initialize error variable
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            // Redirect to dashboard or any other authenticated page
            header("Location: ../home_page.php");
            exit();
        } else {
            // Incorrect password, set error message
            $error = "Invalid password.";
        }
    } else {
        // User does not exist, set error message
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for additional styling */
        body {
            background: linear-gradient(to bottom right, #ff8c00, #ff1493);
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .login-container {
            margin-top: 100px; /* Adjust margin as needed */
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.9); /* Adjust background opacity as needed */
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container form {
            margin-bottom: 20px;
        }
        /* Animation for login button */
        .btn-login {
            background-color: #ff8c00;
            transition: background-color 0.5s ease;
        }
        .btn-login:hover {
            background-color: #ff1493;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <h2>Login</h2>
                    <?php if(!empty($error)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-login">Login</button>
                    </form>
                    <p class="text-center">Don't have an account? <a href="register.php">Register here</a>.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>