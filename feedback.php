<?php
session_start();
include_once 'db1.php';

$event_id = $_GET['event_id'];
$user_id = $_SESSION['user_id']; // Assuming the user is logged in

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    // Check if feedback already exists for the event
    $check_feedback_query = "SELECT * FROM event_feedback WHERE user_id = '$user_id' AND event_id = '$event_id'";
    $feedback_result = mysqli_query($conn, $check_feedback_query);

    if (mysqli_num_rows($feedback_result) > 0) {
        // Update feedback
        $update_query = "UPDATE event_feedback SET rating = '$rating', feedback = '$feedback', updated_at = NOW() WHERE user_id = '$user_id' AND event_id = '$event_id'";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new feedback
        $insert_query = "INSERT INTO event_feedback (user_id, event_id, rating, feedback) VALUES ('$user_id', '$event_id', '$rating', '$feedback')";
        mysqli_query($conn, $insert_query);
    }

    echo "Feedback submitted successfully!";
}
?>

<form action="feedback.php?event_id=<?php echo $event_id; ?>" method="POST">
    <label for="rating">Rating:</label>
    <input type="number" name="rating" min="1" max="5" required><br><br>

    <label for="feedback">Feedback:</label>
    <textarea name="feedback" rows="4" required></textarea><br><br>

    <button type="submit">Submit Feedback</button>
</form>
