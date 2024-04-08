<?php
session_start();
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];

    // Check if a friend request already exists
    $sql_check_request = "SELECT * FROM friend_requests WHERE sender_id='$sender_id' AND receiver_id='$receiver_id'";
    $result_check_request = $conn->query($sql_check_request);
    if ($result_check_request->num_rows == 0) {
        // Insert the friend request into the database
        $sql_insert_request = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES ('$sender_id', '$receiver_id')";
        $conn->query($sql_insert_request);
    }
    // Redirect back to match.php or any other page
    header("Location: match.php");
    exit();
}
?>
