<?php
session_start();
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get friend_id from the form
    $friend_id = $_POST['friend_id'];

    // Delete the friend relationship from the friend_requests table
    $sql_remove_friend = "DELETE FROM friend_requests 
                          WHERE (sender_id='$user_id' AND receiver_id='$friend_id') 
                          OR (sender_id='$friend_id' AND receiver_id='$user_id')";
    if ($conn->query($sql_remove_friend) === TRUE) {
        // Friend removed successfully, redirect back to the friends page
        header("Location: friends.php");
        exit();
    } else {
        // Error occurred while removing friend
        echo "Error: " . $sql_remove_friend . "<br>" . $conn->error;
    }
} else {
    // Redirect if the form is not submitted
    header("Location: friends.php");
    exit();
}
?>
