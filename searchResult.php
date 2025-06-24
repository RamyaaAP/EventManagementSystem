<?php
session_start();

// Assuming you're using a database to store events
require 'db1.php'; // Include database connection

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchQuery) {
    // SQL query to search events based on name or category
    $query = "SELECT * FROM events WHERE event_title LIKE ? OR category LIKE ?";
    $stmt = $conn->prepare($query); // Use $conn instead of $pdo as per your previous connection setup
    $stmt->bind_param("ss", $searchQuery, $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $results = [];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
    <div class="container">
        <h2>Search Results for: <?php echo htmlspecialchars($searchQuery); ?></h2>
        <?php if (count($results) > 0): ?>
            <ul>
                <?php foreach ($results as $event): ?>
                    <li>
                        <a href="viewEvent.php?category=<?php echo urlencode($event['category']); ?>">
                            <?php echo htmlspecialchars($event['event_title']); ?>
                        </a>
                        <p><?php echo htmlspecialchars($event['category']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
