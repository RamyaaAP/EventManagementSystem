<?php
include_once 'db1.php'; // Include database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';  // Include PHPMailer's autoloader

// Check if SMTP settings exist in the database, if not, insert default settings
$smtp_query = "SELECT * FROM email_config WHERE id = 1";  // Check for existing settings
$smtp_result = mysqli_query($conn, $smtp_query);

if (mysqli_num_rows($smtp_result) > 0) {
    // Settings already exist
    $smtp_config = mysqli_fetch_assoc($smtp_result);
} else {
    // Insert default SMTP settings into the database
    $default_smtp_settings = [
        'smtp_host' => 'smtp.gmail.com', // Example: Gmail SMTP host
        'smtp_username' => 'your_email@gmail.com', // Replace with your email address
        'smtp_password' => 'your_app_password', // Replace with your app password or email password
        'smtp_secure' => 'tls', // TLS encryption
        'smtp_port' => 587, // Port for TLS
        'from_email' => 'your_email@gmail.com' // From email address
    ];

    // Insert into the email_config table
    $insert_query = "INSERT INTO email_config (smtp_host, smtp_username, smtp_password, smtp_secure, smtp_port, from_email)
                     VALUES ('{$default_smtp_settings['smtp_host']}', '{$default_smtp_settings['smtp_username']}', '{$default_smtp_settings['smtp_password']}', '{$default_smtp_settings['smtp_secure']}', {$default_smtp_settings['smtp_port']}, '{$default_smtp_settings['from_email']}')";

    if (mysqli_query($conn, $insert_query)) {
        // Now fetch the newly inserted settings
        $smtp_config = $default_smtp_settings;
    } else {
        die('Failed to insert SMTP settings.');
    }
}

// Check if form is submitted and event ID is passed
if (isset($_POST['send_reminder']) && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Get event details from the database
    $event_query = "SELECT event_title, Date, time FROM events WHERE event_id = $event_id";
    $event_result = mysqli_query($conn, $event_query);
    
    if (mysqli_num_rows($event_result) > 0) {
        $event = mysqli_fetch_assoc($event_result);
        $event_title = $event['event_title'];
        $event_date = $event['Date'];
        $event_time = $event['time'];

        // Get users who registered for the event
        $users_query = "SELECT u.first_name, u.email, u.id FROM users u 
                        JOIN registered r ON u.id = r.rid
                        WHERE r.event_id = $event_id";
        $users_result = mysqli_query($conn, $users_query);

        if (mysqli_num_rows($users_result) > 0) {
            // Loop through users and send email reminder
            while ($user = mysqli_fetch_assoc($users_result)) {
                $to = $user['email'];
                $subject = "Reminder: Upcoming Event - $event_title";
                $message = "
                    <html>
                    <head>
                        <title>Event Reminder</title>
                    </head>
                    <body>
                        <p>Dear " . $user['first_name'] . ",</p>
                        <p>This is a friendly reminder for the upcoming event:</p>
                        <h3>$event_title</h3>
                        <p><strong>Date:</strong> $event_date</p>
                        <p><strong>Time:</strong> $event_time</p>
                        <p>We look forward to seeing you there!</p>
                    </body>
                    </html>
                ";

                // Set up PHPMailer to send email securely using database-fetched settings
                $mail = new PHPMailer(true);
                try {
                    // Server settings (using fetched SMTP settings)
                    $mail->isSMTP();
                    $mail->Host = $smtp_config['smtp_host'];  // SMTP server
                    $mail->SMTPAuth = true;
                    $mail->Username = $smtp_config['smtp_username'];  // Email username
                    $mail->Password = $smtp_config['smtp_password'];  // Email password
                    $mail->SMTPSecure = $smtp_config['smtp_secure'];  // Encryption method
                    $mail->Port = $smtp_config['smtp_port'];  // SMTP Port

                    //Recipients
                    $mail->setFrom($smtp_config['from_email'], 'Event Reminder');  // Sender email from DB
                    $mail->addAddress($to);  // Add the recipient's email

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body    = $message;

                    // Send email
                    $mail->send();
                    echo 'Reminder sent to: ' . $user['first_name'] . '<br>';

                    // Log the email in the database
                    $insert_log_query = "INSERT INTO email_logs (event_id, user_id, recipient_email, subject, message, status)
                                         VALUES ($event_id, " . $user['id'] . ", '$to', '$subject', '" . mysqli_real_escape_string($conn, $message) . "', 'sent')";
                    mysqli_query($conn, $insert_log_query);
                } catch (Exception $e) {
                    // Log the failed email status
                    $insert_log_query = "INSERT INTO email_logs (event_id, user_id, recipient_email, subject, message, status)
                                         VALUES ($event_id, " . $user['id'] . ", '$to', '$subject', '" . mysqli_real_escape_string($conn, $message) . "', 'failed')";
                    mysqli_query($conn, $insert_log_query);

                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
            // Redirect back to the event list page with a success message
            header("Location: adminPage.php?reminder_sent=true");
            exit();
        } else {
            // No users found for this event
            header("Location: adminPage.php?reminder_error=no_users");
            exit();
        }
    } else {
        // Event not found
        header("Location: adminPage.php?reminder_error=event_not_found");
        exit();
    }
} else {
    // Invalid request, redirect back to the event list page
    header("Location: adminPage.php?reminder_error=invalid_request");
    exit();
}
?>
