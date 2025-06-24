<!-- smtp_settings_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMTP Settings</title>
</head>
<body>
    <h2>Enter SMTP Settings</h2>
    <form action="save_smtp_settings.php" method="POST">
        <label for="smtp_host">SMTP Host:</label>
        <input type="text" id="smtp_host" name="smtp_host" required><br><br>

        <label for="smtp_username">SMTP Username:</label>
        <input type="email" id="smtp_username" name="smtp_username" required><br><br>

        <label for="smtp_password">SMTP Password:</label>
        <input type="password" id="smtp_password" name="smtp_password" required><br><br>

        <label for="smtp_port">SMTP Port:</label>
        <input type="number" id="smtp_port" name="smtp_port" required><br><br>

        <label for="smtp_secure">SMTP Secure:</label>
        <input type="text" id="smtp_secure" name="smtp_secure" required><br><br>

        <label for="from_email">From Email:</label>
        <input type="email" id="from_email" name="from_email" required><br><br>

        <input type="submit" value="Save SMTP Settings">
    </form>
</body>
</html>
