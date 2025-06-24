<!-- save_smtp_settings.php -->
<?php
include_once 'db1.php';  // Include your DB connection

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $smtp_host = mysqli_real_escape_string($conn, $_POST['smtp_host']);
    $smtp_username = mysqli_real_escape_string($conn, $_POST['smtp_username']);
    $smtp_password = mysqli_real_escape_string($conn, $_POST['smtp_password']);
    $smtp_port = mysqli_real_escape_string($conn, $_POST['smtp_port']);
    $smtp_secure = mysqli_real_escape_string($conn, $_POST['smtp_secure']);
    $from_email = mysqli_real_escape_string($conn, $_POST['from_email']);

    // Insert data into the email_config table
    $insert_query = "INSERT INTO email_config (smtp_host, smtp_username, smtp_password, smtp_port, smtp_secure, from_email)
                     VALUES ('$smtp_host', '$smtp_username', '$smtp_password', $smtp_port, '$smtp_secure', '$from_email')";

    if (mysqli_query($conn, $insert_query)) {
        echo "SMTP settings saved successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
