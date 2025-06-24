<?php
session_start();
require 'db1.php'; // Include your database connection

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    
    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $error_message = "Email is already registered.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new user into the database
        $insert_query = "INSERT INTO users (first_name, last_name, email, password, phone, address, category) 
                         VALUES ('$first_name', '$last_name', '$email', '$hashed_password', '$phone', '$address', '$category')";
        
        if (mysqli_query($conn, $insert_query)) {
            // Redirect to login page after successful registration
            header("Location: loginfirst.php"); // Ensure that loginfirst.php exists
            exit(); // Always call exit() after header to stop further execution
        } else {
            $error_message = "There was an error registering your account.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php require 'utils/styles.php'; ?>
</head>
<body>
    <?php require 'utils/header.php'; ?>
    
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
        
        <form method="POST" action="regfirst.php"> <!-- Ensure registerfirst.php is in the correct location -->
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category:</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <p>Already have an account? <a href="loginfirst.php">Login here</a></p>
    </div>
    
    <?php require 'utils/footer.php'; ?>
</body>
</html>
