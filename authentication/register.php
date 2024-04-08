<?php
include('../db.php'); // Include the database connection file

// Initialize error variable
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $bio = $_POST['bio'];
    $gender = $_POST['gender'];

    // Map gender to database value
    // male=1       female=0
    if ($gender == 'male') {
        $gender_value = 1;
    } elseif ($gender == 'female') {
        $gender_value = 0;
    } else {
        // Handle other gender options if needed
        // For example, you might display an error message and redirect the user back to the registration page
        header("Location: register.php?error=InvalidGender");
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Default profile picture path
    $default_profile_picture = "https://t4.ftcdn.net/jpg/00/64/67/27/360_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg"; 

    // Insert user data into database
    $sql = "INSERT INTO users (email, first_name, last_name, password, age, bio, gender, profile_picture) 
            VALUES ('$email', '$first_name', '$last_name', '$hashed_password', '$age', '$bio', '$gender_value', '$default_profile_picture')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        .container {
            margin-top: 100px; /* Adjust margin as needed */
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
        .card-header {
            background-color: #fff;
            border-bottom: none;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        .card-body {
            background-color: rgba(255, 255, 255, 0.9);
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        /* Button animation */
        .btn-register {
            background-color: #ff8c00;
            transition: background-color 0.5s ease;
        }
        .btn-register:hover {
            background-color: #ff1493;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>Register</h2>
                    </div>
                    <div class="card-body">
                        <?php if(!empty($error)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" name="first_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" name="last_name" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Password:</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="age">Age:</label>
                                        <input type="number" name="age" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Gender:</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="bio">Bio:</label>
                                <textarea name="bio" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-register">Register</button>
                        </form>
                        <p class="text-center">Already have an account? <a href="login.php">Login here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>