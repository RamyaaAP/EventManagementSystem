<?php
session_start();
include_once 'db1.php'; // Include your database connection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $user_id = $_SESSION['id']; // Get the logged-in user's ID
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']); // Assuming event_id is passed from the event page
    $rating = mysqli_real_escape_string($conn, $_POST['rating']); // Capture the rating value
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']); // Capture feedback text

    // Insert feedback into the database
    $query = "INSERT INTO event_feedback (user_id, event_id, rating, feedback) 
              VALUES ('$user_id', '$event_id', '$rating', '$feedback')";

    if (mysqli_query($conn, $query)) {
        echo "<h2>Thank you for your feedback!</h2>";
    } else {
        echo "<h2>There was an error submitting your feedback. Please try again later.</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style1.css"> 
    <title>Feedback Form</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1>Give Feedback</h1>

        <!-- Feedback Form -->
        <form method="POST" action="profile.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="category">Feedback Category:</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="Overall Experience">Overall Experience</option>
                    <option value="Event Organization">Event Organization</option>
                    <option value="Session/Speaker">Session/Speaker</option>
                    <option value="Venue">Venue</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rating">Rating (1 to 5):</label>
                <select name="rating" id="rating" class="form-control" required>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>

            <div class="form-group">
                <label for="feedback">Your Feedback:</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
</body>
</html>