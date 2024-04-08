<?php
session_start();
include('../db.php');

$user_id = $_SESSION['user_id'];

// Retrieve friends from friend_requests where status is 'accepted'
$sql_friends = "SELECT sender_id, receiver_id FROM friend_requests WHERE (sender_id='$user_id' OR receiver_id='$user_id') AND status='accepted'";
$result_friends = $conn->query($sql_friends);

$friends = array();
if ($result_friends->num_rows > 0) {
    while ($row = $result_friends->fetch_assoc()) {
        if ($row['sender_id'] == $user_id) {
            $friends[] = $row['receiver_id'];
        } else {
            $friends[] = $row['sender_id'];
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $request_id = $_POST['request_id'];

    if (isset($_POST['accept'])) {
        // Update friend request status to 'accepted'
        $sql_update_request = "UPDATE friend_requests SET status='accepted' WHERE id='$request_id'";
        $conn->query($sql_update_request);
    } elseif (isset($_POST['decline'])) {
        // Update friend request status to 'declined'
        $sql_update_request = "UPDATE friend_requests SET status='declined' WHERE id='$request_id'";
        $conn->query($sql_update_request);
    } elseif (isset($_POST['remove'])) {
        // Remove friend
        $friend_id = $_POST['friend_id'];
        $sql_remove_friend = "DELETE FROM friend_requests WHERE (sender_id='$user_id' AND receiver_id='$friend_id') OR (sender_id='$friend_id' AND receiver_id='$user_id')";
        $conn->query($sql_remove_friend);
    }
    // Redirect back to friend_requests.php or any other page
    header("Location: friends.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css"> <!-- Include your custom CSS file -->
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Friends</h2>
        <?php if (!empty($friends)) {
            foreach ($friends as $friend_id) {
                // Fetch the friend's first name and last name
                $sql_friend_name = "SELECT first_name, last_name FROM users WHERE id='$friend_id'";
                $result_friend_name = $conn->query($sql_friend_name);
                if ($result_friend_name->num_rows == 1) {
                    $friend_name = $result_friend_name->fetch_assoc();
                    ?>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Friend</h5>
                            <p class="card-text">You are friends with <?php echo $friend_name['first_name'] . ' ' . $friend_name['last_name']; ?></p>
                            <form action="" method="post">
                                <input type="hidden" name="friend_id" value="<?php echo $friend_id; ?>">
                                <button type="submit" name="remove" class="btn btn-danger">Remove Friend</button>
                                <!-- Button without any action -->
                                <button type="button" class="btn btn-secondary ml-2">PM</button>
                            </form>
                        </div>
                    </div>
                <?php }
            }
        } else { ?>
            <p>No friends found.</p>
        <?php } ?>
        
        <hr>
        
        <h2 class="mt-4">Friend Requests</h2>
        <?php
        $sql_requests = "SELECT friend_requests.id, friend_requests.sender_id, users.first_name, users.last_name
                 FROM friend_requests
                 INNER JOIN users ON friend_requests.sender_id = users.id
                 WHERE friend_requests.receiver_id='$user_id' AND friend_requests.status='pending'";
        $result_requests = $conn->query($sql_requests);
        if ($result_requests->num_rows > 0) {
            while ($row = $result_requests->fetch_assoc()) { ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Friend Request</h5>
                        <p class="card-text">You have a friend request from <?php echo $row['first_name'] . ' ' . $row['last_name']; ?></p>
                        <form action="" method="post">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="accept" class="btn btn-primary mr-2">Accept</button>
                            <button type="submit" name="decline" class="btn btn-danger">Decline</button>
                        </form>
                    </div>
                </div>
            <?php }
        } else { ?>
            <p>No friend requests found.</p>
        <?php } ?>
    </div>
</body>
</html>
