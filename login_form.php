<?php
include_once 'db1.php';
session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Preranothsava</title>
    <style>
        span.error {
            color: red;
        }
        .form-control::placeholder {
            color: #ccc;
            font-style: italic;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
    <?php require 'utils/styles.php'; ?>
    <!--css links. file found in utils folder-->
</head>

<body>
    <?php require 'utils/header3.php'; ?>
    <!--header content. file found in utils folder-->
    <div class="content">
        <!--body content holder-->
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <?php
                // Display error message if login failed
                if (isset($error_message)) {
                    echo "<div class='error-message'>$error_message</div>";
                }
                ?>

                <form method="POST" action="login_form.php">
                    <!--form-->

                    <!--username field-->
                    <label for="username">UserName:</label><br>
                    <input type="text" id="username" name="name" class="form-control" placeholder="Enter Username" required><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required><br>

                    <button type="submit" name="update" class="btn btn-default">Login</button>
                </form>
            </div><!-- col md 6 div -->
        </div><!-- container div -->
        <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
    </div><!-- content div -->

    <?php require 'utils/footer.php'; ?>
    <!--footer content. file found in utils folder-->
</body>

</html>

<?php
if (isset($_POST["update"])) {
    // Sanitize and capture the user input manually
    $myusername = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);  // Avoid XSS by sanitizing special characters
    $mypassword = $_POST['password'];  // No need to sanitize password, but validate it

    // Hardcoded credentials for validation (for demo purposes)
    $validUsername = 'JANE';
    $validPassword = 'PRINCESS'; 

    // Validate the credentials
    if ($myusername === $validUsername && $mypassword === $validPassword) {
        // If username and password are correct, set session and redirect
        $_SESSION['username'] = $myusername; 
        header('Location: adminPage.php'); // Redirect to admin page after successful login
        exit;
    } else {
        // If credentials are invalid, set error message
        $error_message = 'Invalid login credentials. Please try again.';
    }
}
?>
