<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['payment_method'] = $_POST['payment_option'];
    // Redirect to appropriate payment method page
    if ($_SESSION['payment_method'] == 'credit_card') {
        header("Location: credit_card_payment.php");
    } elseif ($_SESSION['payment_method'] == 'paypal') {
        header("Location: paypal_payment.php");
    } elseif ($_SESSION['payment_method'] == 'upi') {
        header("Location: upi_payment.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Payment Method</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Center content vertically and horizontally */
        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f4f4f9;
        }

        /* Form container styling */
        .container {
            text-align: center;
            background-color: #fff;
            padding: 2em 3em;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
        }

        /* Title styling */
        h1 {
            font-size: 2em;
            margin-bottom: 1em;
            color: #333;
        }

        /* Label and input styling */
        label {
            font-size: 1.1em;
            margin-right: 10px;
            color: #555;
        }

        input[type="radio"] {
            margin-right: 5px;
            transform: scale(1.2);
        }

        /* Button styling */
        button {
            margin-top: 1.5em;
            padding: 0.7em 2em;
            font-size: 1.1em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Select a Payment Method</h1>
        <form method="POST">
            <label for="credit_card">Credit Card</label>
            <input type="radio" name="payment_option" value="credit_card" required><br><br>

            <label for="paypal">PayPal</label>
            <input type="radio" name="payment_option" value="paypal"><br><br>

            <label for="upi">UPI</label>
            <input type="radio" name="payment_option" value="upi"><br><br>

            <button type="submit">Proceed</button>
        </form>
    </div>
</body>
</html>
