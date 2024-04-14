<?php
session_start();

include('../db.php');

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['block'])) {
    $blocked_user_id = $_POST['user_id'];

    // Insert the blocked user into the friend_requests table with status 'blocked'
    $sql_block_user = "INSERT INTO friend_requests (sender_id, receiver_id, status) VALUES ('$user_id', '$blocked_user_id', 'blocked')";
    $conn->query($sql_block_user);

    // Redirect back to match.php or any other page
    header("Location: ../home_page.php");
    exit();
}
?>
