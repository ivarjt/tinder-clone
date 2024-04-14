<?php
session_start(); // Start session

include('../db.php'); // Include the database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's gender
$sql_user_gender = "SELECT gender FROM users WHERE id='$user_id'";
$result_user_gender = $conn->query($sql_user_gender);
if ($result_user_gender->num_rows == 1) {
    $user_gender = $result_user_gender->fetch_assoc()['gender'];
} else {
    // User not found, redirect to login
    header("Location: login.php");
    exit();
}

// Fetch users of the opposite gender with their age, excluding already friends and blocked users
$opposite_gender = ($user_gender == 1) ? 0 : 1; // Assuming 1 for male and 0 for female
$sql_users_opposite_gender = "SELECT u.id, u.first_name, u.last_name, u.bio, u.profile_picture, u.age
                               FROM users u
                               WHERE u.gender='$opposite_gender' 
                               AND u.id<>'$user_id'
                               AND u.id NOT IN (
                                   SELECT CASE
                                       WHEN fr.sender_id='$user_id' THEN fr.receiver_id
                                       ELSE fr.sender_id
                                   END AS friend_id
                                   FROM friend_requests fr
                                   WHERE (fr.sender_id='$user_id' OR fr.receiver_id='$user_id')
                                   AND (fr.status='accepted' OR fr.status='blocked')
                               )";
$result_users_opposite_gender = $conn->query($sql_users_opposite_gender);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css"> <!-- Include your custom CSS file -->
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Matches</h2>
        <div class="row mt-4">
            <?php if ($result_users_opposite_gender->num_rows > 0) {
                while ($row = $result_users_opposite_gender->fetch_assoc()) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $row['profile_picture']; ?>" class="card-img-top" alt="Profile Picture">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></h5>
                                <p class="card-text">Age: <?php echo $row['age']; ?></p>
                                <p class="card-text"><?php echo $row['bio']; ?></p>
                                <div class="text-center">
                                    <form action="match/send_friend_request.php" method="post">
                                        <input type="hidden" name="receiver_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-check" aria-hidden="true"></i> Like</button>
                                    </form>
                                    <form action="match/block_user.php" method="post"> <!-- Change action to block_user.php -->
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="block" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Dislike</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <p>No matches found.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
