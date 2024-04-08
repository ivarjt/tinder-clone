<?php
session_start(); // Start session

include('../db.php'); // Include the database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    // User not found, redirect to login
    header("Location: login.php");
    exit();
}

// Handle form submission for updating bio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_bio'])) {
    $new_bio = $_POST['bio'];
    $sql_update_bio = "UPDATE users SET bio='$new_bio' WHERE id='$user_id'";
    if ($conn->query($sql_update_bio) === TRUE) {
        // Redirect to profile page with success message
        header("Location: profile.php?success=BioUpdated");
        exit();
    } else {
        // Redirect to profile page with error message
        header("Location: profile.php?error=UpdateError");
        exit();
    }
}

// Handle form submission for updating profile picture via link
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_picture'])) {
    $new_profile_picture = $_POST['profile_picture'];
    $sql_update_picture = "UPDATE users SET profile_picture='$new_profile_picture' WHERE id='$user_id'";
    if ($conn->query($sql_update_picture) === TRUE) {
        // Redirect to profile page with success message
        header("Location: profile.php?success=PictureUpdated");
        exit();
    } else {
        // Redirect to profile page with error message
        header("Location: profile.php?error=UpdateError");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for additional styling */
        body {
            background: linear-gradient(to bottom, #ff8c00, #ff1493);
            font-family: Arial, sans-serif;
            padding-top: 20px;
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            width: 80%;
            max-width: 600px;
        }
        .profile-picture img {
            max-width: 150px;
            height: auto;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .update-bio textarea {
            width: 100%;
            height: 100px;
            resize: none;
        }
        .update-bio button,
        .update-picture button,
        .btn-logout,
        .btn-home {
            width: 100%;
            transition: background-color 0.5s ease;
            border: none;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .update-bio button,
        .update-picture button {
            background-color: #ff8c00; /* Orange */
        }
        .update-bio button:hover,
        .update-picture button:hover {
            background-color: #ff1493; /* Pink */
        }
        .btn-logout {
            background-color: #ff1493; /* Pink */
            width: auto;
            padding: 5px 10px;
            margin-right: 10px;
        }
        .btn-logout:hover {
            background-color: #ff8c00; /* Orange */
        }
        .btn-home {
            background-color: #ff8c00; /* Orange */
            width: auto;
            padding: 5px 10px;
        }
        .btn-home:hover {
            background-color: #ff1493; /* Pink */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Welcome, <?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?>!</h2>
        <div class="profile-picture text-center">
            <br>
            <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
        </div>
        <div class="update-bio">
            <h3>Bio</h3>
            <form action="" method="post">
                <textarea name="bio" class="form-control" required><?php echo $user['bio']; ?></textarea>
                <button type="submit" name="update_bio" class="btn btn-primary mt-3">Update Bio</button>
            </form>
            <br>
        </div>
        <div class="update-picture">
            <h3>Profile Picture</h3>
            <form action="" method="post">
                <input type="text" name="profile_picture" class="form-control mb-3" placeholder="Enter image URL" required>
                <button type="submit" name="update_picture" class="btn btn-primary">Update Picture</button>
            </form>
        </div>
        <div class="text-center mt-3">
            <a href="logout.php" class="btn btn-logout btn-danger">Logout</a>
            <a href="../home.php" class="btn btn-home btn-secondary">Home</a>
        </div>
    </div>
</body>
</html>