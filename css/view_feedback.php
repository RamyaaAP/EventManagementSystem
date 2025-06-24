<?php
session_start();
include 'db.php'; // Database connection

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php'); // Redirect to login if admin not logged in
    exit();
}

$event_id = $_GET['event_id']; // Get event ID from URL

// Fetch feedback for the event
$feedback_query = "SELECT event_feedback.*, users.username 
                   FROM event_feedback 
                   JOIN users ON event_feedback.user_id = users.id
                   WHERE event_feedback.event_id = $event_id";
$feedback_result = $conn->query($feedback_query);

echo "<h2>Feedback for Event ID: $event_id</h2>";

if ($feedback_result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>User</th>
                <th>Rating</th>
                <th>Feedback</th>
                <th>Actions</th>
            </tr>";

    while ($feedback = $feedback_result->fetch_assoc()) {
        $feedback_id = $feedback['id'];
        echo "<tr>
                <td>" . $feedback['username'] . "</td>
                <td>" . $feedback['rating'] . "</td>
                <td>" . $feedback['feedback'] . "</td>
                <td>
                    <a href='delete_feedback.php?feedback_id=$feedback_id'>Delete</a>
                </td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No feedback available for this event.</p>";
}
?>
