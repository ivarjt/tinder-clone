<?php
include('../db.php'); // Include the database connection file
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT username, email, age, gender, bio FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch user data
} else {
    echo "User not found.";
    exit();
}

$message = ''; // Define $message variable here

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bio = $_POST['bio'];

    // Update user's bio in the database
    $sql_update = "UPDATE users SET bio = '$bio' WHERE id = $user_id";
    if ($conn->query($sql_update) === TRUE) {
        $message = "Bio updated successfully.";
        $user['bio'] = $bio; // Update the user object with new bio
    } else {
        $message = "Error updating bio: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $user['username']; ?></h2>
        <div>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Age: <?php echo $user['age']; ?></p>
            <p>Gender: <?php echo $user['gender']; ?></p>
        </div>
        <div>
            <h3>Update Bio</h3>
            <form action="" method="post">
                <div class="form-group">
                    <label for="bio">Bio:</label>
                    <textarea name="bio" required><?php echo $user['bio']; ?></textarea>
                </div>
                <!-- Hidden field to store user ID -->
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit">Update Bio</button>
            </form>
        </div>
        <?php if ($message) {
            echo "<p>$message</p>";
        } ?>
        <p><a href="logout.php">Logout</a></p>
        <p><a href="../home.php">Homepage</a></p>
    </div>
</body>
</html>
