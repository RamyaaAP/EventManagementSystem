<?php
session_start();
include 'db.php'; // Database connection

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Redirect to login if admin not logged in
    exit();
}

$feedback_id = $_GET['feedback_id']; // Get the feedback ID from URL

// Delete the feedback from the database
$delete_feedback_query = "DELETE FROM event_feedback WHERE id = $feedback_id";
if ($conn->query($delete_feedback_query) === TRUE) {
    echo "Feedback deleted successfully!";
    header("Location: view_feedback.php?event_id=" . $_GET['event_id']); // Redirect back to the feedback page
    exit();
} else {
    echo "Error deleting feedback: " . $conn->error;
}
?>
