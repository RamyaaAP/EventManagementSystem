<?php
// Example of establishing a PDO connection (replace with your actual credentials)
$host = '127.0.0.1';  // Your database host, typically localhost or an IP address
$dbname = 'event_management';  // Your database name
$username = 'root';  // Your database username
$password = '';  // Your database password, leave empty if using default XAMPP setup

try {
    // Create a PDO instance and set the error mode to exception
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception for easier debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle error gracefully
    echo "Connection failed: " . $e->getMessage();
}
?>
