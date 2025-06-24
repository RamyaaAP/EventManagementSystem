<?php
session_start();
include_once 'db1.php';

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: loginfirst.php");
    exit();
}

// Get the user's usn from the session
$user_id = $_SESSION['id'];
$user_query = "SELECT id FROM users WHERE id = '$user_id'";
$user_result = mysqli_query($conn, $user_query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user = mysqli_fetch_assoc($user_result);
    $usn = $user['id'];
} else {
    echo "User details not found!";
    exit();
}

// Get ticket information from the `registered` table
$ticket_query = "SELECT r.ticket_code, e.event_title, r.date_registered 
                 FROM registered r 
                 JOIN events e ON r.event_id = e.event_id 
                 WHERE r.rid = '$usn'";
$ticket_result = mysqli_query($conn, $ticket_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Ticket</title>
    <link rel="stylesheet" type="text/css" href="css/style2.css">
</head>
<body>
    <h1>Your Ticket</h1>
    <?php if ($ticket_result && mysqli_num_rows($ticket_result) > 0): ?>
        <?php while ($ticket = mysqli_fetch_assoc($ticket_result)): ?>
            <p><strong>Event:</strong> <?php echo htmlspecialchars($ticket['event_title']); ?></p>
            <p><strong>Ticket ID:</strong> <?php echo htmlspecialchars($ticket['ticket_code']); ?></p>
            <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($ticket['date_registered']); ?></p>
            <hr>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No tickets found.</p>
    <?php endif; ?>
</body>
</html>
