<?php
session_start();
include 'db1.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = $_GET['event_id'];

// Check if the user has already given feedback for this event
$query = "SELECT * FROM event_feedback WHERE user_id = $user_id AND event_id = $event_id";
$feedback_result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];

    if ($feedback_result->num_rows > 0) {
        // Update existing feedback
        $update_query = "UPDATE event_feedback SET rating = $rating, feedback = '$feedback' WHERE user_id = $user_id AND event_id = $event_id";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new feedback
        $insert_query = "INSERT INTO event_feedback (user_id, event_id, rating, feedback) VALUES ($user_id, $event_id, $rating, '$feedback')";
        mysqli_query($conn, $insert_query);
    }

    header("Location: event_page.php?event_id=$event_id");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave Feedback</title>
</head>
<body>
    <h1>Leave Feedback for Event</h1>

    <?php if ($feedback_result->num_rows > 0) {
        $existing_feedback = mysqli_fetch_assoc($feedback_result);
    ?>
        <h3>Your Previous Feedback</h3>
        <p>Rating: <?php echo $existing_feedback['rating']; ?></p>
        <p>Feedback: <?php echo $existing_feedback['feedback']; ?></p>
    <?php } ?>

    <form action="event_feedback.php?event_id=<?php echo $event_id; ?>" method="POST">
        <label for="rating">Rating (1-5):</label><br>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br><br>

        <label for="feedback">Feedback:</label><br>
        <textarea id="feedback" name="feedback" required></textarea><br><br>

        <input type="submit" value="Submit Feedback">
    </form>
</body>
</html>
