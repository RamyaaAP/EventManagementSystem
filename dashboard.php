<?php
session_start();
include 'db1.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch events the user has registered for
$query = "SELECT * FROM events WHERE event_id IN (SELECT event_id FROM user_events WHERE user_id = $user_id)";
$events_result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
</head>
<body>
    <h1>Welcome to Your Dashboard</h1>
    <p><a href="logout.php">Logout</a></p>
    
    <h2>Your Events</h2>
    <?php if (mysqli_num_rows($events_result) > 0) { ?>
        <ul>
        <?php while ($event = mysqli_fetch_assoc($events_result)) { ?>
            <li>
                <strong><?php echo htmlspecialchars($event['event_title']); ?></strong>
                <a href="event_page.php?event_id=<?php echo $event['event_id']; ?>">View Event</a>
            </li>
        <?php } ?>
        </ul>
    <?php } else { ?>
        <p>You are not registered for any events.</p>
    <?php } ?>
</body>
</html>
