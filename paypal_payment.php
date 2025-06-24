<?php
session_start();

// Check if the payment method is PayPal
if ($_SESSION['payment_method'] != 'paypal') {
    echo "Invalid payment method.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate PayPal payment processing
    $_SESSION['payment_success'] = true;
    header("Location: payment_success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PayPal Payment</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
</head>
<body>
    <div class="container">
        <h1>PayPal Payment</h1>
        <form method="POST">
            <label for="paypal_email">PayPal Email ID</label>
            <input type="email" name="paypal_email" required><br><br>

            <label for="confirm_email">Confirm PayPal Email</label>
            <input type="email" name="confirm_email" required><br><br>

            <label for="payment_amount">Amount to Pay</label>
            <input type="text" name="payment_amount" value="250.00" required><br><br>

            <button type="submit">Pay with PayPal</button>
        </form>
    </div>
</body>
</html>
