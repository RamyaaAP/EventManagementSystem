<?php
session_start();
require 'db1.php'; // Include your database connection

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Use real escape string to protect against SQL injection
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

    // Query to fetch user with the given email
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    // If user exists
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify the hashed password
        if (password_verify($password, $user['password'])) {
            // Store user data in session variables
            $_SESSION['id'] = $user['id'];  // Store user ID in the session
            $_SESSION['email'] = $user['email'];  // Store email in the session
            $_SESSION['category'] = $user['category']; // Store category in the session

            // Redirect to index.php after login
            header("Location: index.php");
            exit();
        } else {
            // If password is incorrect
            $error_message = "Invalid email or password.";
        }
    } else {
        // If email does not exist
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Login</title>
    <?php require 'utils/styles.php'; ?> <!-- Include your styles -->
</head>
<body>
    <?php require 'utils/header.php'; ?> <!-- Include header -->

    <div class="content">
        <div class="container">
            <div class="col-md-12">
                <h1>Login</h1>
                
                <!-- Display error message if any -->
                <?php if (isset($error_message)) { ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php } ?>

                <!-- Login Form -->
                <form method="post" action="loginfirst.php">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Login</button>
                </form>

                <p>Don't have an account? <a href="regfirst.php">Register here</a></p>
            </div>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?> <!-- Include footer -->
</body>
</html>
