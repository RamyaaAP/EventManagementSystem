<?php
session_start();

// Check if the payment method is net banking
if ($_SESSION['payment_method'] != 'net_banking') {
    echo "Invalid payment method.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate net banking payment processing
    $_SESSION['payment_success'] = true;
    header("Location: payment_success.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Net Banking Payment</title>
</head>
<body>
    <h1>Net Banking Payment</h1>
    <form method="POST">
        <label for="bank_name">Bank Name</label>
        <input type="text" name="bank_name" required><br><br>

        <label for="account_number">Account Number</label>
        <input type="text" name="account_number" required><br><br>

        <label for="ifsc_code">IFSC Code</label>
        <input type="text" name="ifsc_code" required><br><br>

        <label for="account_holder_name">Account Holder Name</label>
        <input type="text" name="account_holder_name" required><br><br>

        <button type="submit">Pay with Net Banking</button>
    </form>
</body>
</html>
