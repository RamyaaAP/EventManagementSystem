<?php
session_start();

// Check if the payment method is UPI
if ($_SESSION['payment_method'] != 'upi') {
    echo "Invalid payment method.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate UPI payment processing
    $_SESSION['payment_success'] = true;
    header("Location: payment_success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPI Payment</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
</head>
<body>
    <div class="container">
        <h1>UPI Payment</h1>
        <form method="POST">
            <label for="upi_id">UPI ID</label>
            <input type="text" name="upi_id" required><br><br>

            <label for="confirm_upi_id">Confirm UPI ID</label>
            <input type="text" name="confirm_upi_id" required><br><br>

            <label for="payment_amount">Amount to Pay</label>
            <input type="text" name="payment_amount" value="100.00" required><br><br>

            <button type="submit">Pay with UPI</button>
        </form>
    </div>
</body>
</html>
