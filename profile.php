<?php
session_start();
include_once 'db1.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo "Session ID is not set.";
    exit();
}

// Debugging: Check the session ID value
//echo "Session ID: " . $_SESSION['id'] . "<br>";

// Get user details from the `users` table
$user_id = $_SESSION['id']; // Ensure the ID is valid
$user_query = "SELECT * FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

// Debugging: Check if query was successful
if (!$user_result) {
    echo "Error in query: " . mysqli_error($conn);
    exit();
}

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user = mysqli_fetch_assoc($user_result);
} else {
    echo "User details not found!";
    exit();
}

// Get registered events for the user from the `registered` table
$event_query = "SELECT e.event_title, r.date_registered FROM events e 
                JOIN registered r ON e.event_id = r.event_id 
                WHERE r.rid = '{$user['id']}'";
$event_result = mysqli_query($conn, $event_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <a class="navbar-brand">
                    <h2>CEG EVENTS</h2>
                </a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="profile.php"><strong>Profile</strong></a></li>
                    <li><a href="logout.php"><strong>Logout</strong></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h1>

        <div class="profile-section">
            <h2>Your Profile</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        </div>

        <hr>

        <div class="events-section">
            <h2>Your Registered Events</h2>
            <?php if ($event_result && mysqli_num_rows($event_result) > 0): ?>
                <ul>
                    <?php while ($event = mysqli_fetch_assoc($event_result)): ?>
                        <li><?php echo htmlspecialchars($event['event_title']); ?> (Registered on: <?php echo htmlspecialchars($event['date_registered']); ?>)</li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>You haven't registered for any events yet.</p>
            <?php endif; ?>
        </div>
        <a href="feedback1.php">FEEDBACK</a>
    </div>
</body>
</html>
