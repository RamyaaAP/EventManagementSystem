<?php
// Start the session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'db1.php';

$event_id = isset($_GET['event_id']) ? $_GET['event_id'] : null;

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>Please log in to view or submit feedback for this event.</p>";
    exit; // Stop further processing
}

$user_id = $_SESSION['user_id'];

// Fetch event information if event_id is valid
if ($event_id) {
    $query = "SELECT * FROM events WHERE event_id = '$event_id'";
    $result = mysqli_query($conn, $query);
    $event = mysqli_fetch_assoc($result);

    // Check if feedback already exists
    $check_feedback_query = "SELECT * FROM event_feedback WHERE user_id = '$user_id' AND event_id = '$event_id'";
    $feedback_result = mysqli_query($conn, $check_feedback_query);

    if ($feedback_result && mysqli_num_rows($feedback_result) > 0) {
        $feedback = mysqli_fetch_assoc($feedback_result);
        // Display the existing feedback
        echo "<h3>Your Feedback</h3>";
        echo "<p>Rating: " . htmlspecialchars($feedback['rating']) . "</p>";
        echo "<p>Feedback: " . htmlspecialchars($feedback['feedback']) . "</p>";
        echo "<p><small>Last Updated: " . htmlspecialchars($feedback['updated_at']) . "</small></p>";
    } else {
        echo "<p>You have not submitted feedback for this event yet.</p>";
    }
} else {
    echo "<p>Event not found.</p>";
}
?>

<a href="feedback.php?event_id=<?php echo htmlspecialchars($event_id); ?>">Leave/Update Feedback</a>
