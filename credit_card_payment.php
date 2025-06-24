<?php
session_start();

// Check if the payment method is credit card
if ($_SESSION['payment_method'] != 'credit_card') {
    echo "Invalid payment method.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate payment processing
    $_SESSION['payment_success'] = true;
    header("Location: payment_success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Credit Card Payment</title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
</head>
<body>
    <div class="container">
        <h1>Credit Card Payment</h1>
        <form method="POST">
            <label for="card_number">Card Number</label>
            <input type="text" name="card_number" required><br><br>

            <label for="expiry">Expiry Date (MM/YY)</label>
            <input type="text" name="expiry" required><br><br>

            <label for="cvv">CVV</label>
            <input type="text" name="cvv" required><br><br>

            <label for="name_on_card">Name on Card</label>
            <input type="text" name="name_on_card" required><br><br>

            <label for="billing_address">Billing Address</label>
            <input type="text" name="billing_address" required><br><br>

            <button type="submit">Pay</button>
        </form>
    </div>
</body>
</html>
