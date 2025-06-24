<?php
session_start();

// Check if payment_method was passed, e.g., via session or POST, otherwise set a default
if (isset($_SESSION['payment_method'])) {
    $payment_method = $_SESSION['payment_method'];
} elseif (isset($_POST['payment_method'])) {
    $payment_method = $_POST['payment_method'];
} else {
    $payment_method = "a selected method"; // Default fallback
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link rel="stylesheet" type="text/css" href="css/payments.css">
</head>
<body>
    <div class="container">
        <h1>Payment Successful</h1>
        <p>You have successfully paid using <?php echo htmlspecialchars($payment_method); ?>.</p>

        <h3>Your Ticket Information:</h3>
        <p>Your ticket is ready! You can either view your ticket below:</p>

        <a href="ticket.php">View Ticket</a> 
    </div>
</body>
</html>
