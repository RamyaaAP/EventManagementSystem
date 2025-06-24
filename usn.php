<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Preranothsava</title>
    <?php require 'utils/styles.php'; ?><!-- CSS links. File found in utils folder -->

    <!-- Add style for watermark -->
    <style>
        .form-control::placeholder {
            color: #ccc; /* Color of the placeholder text */
            font-style: italic; /* Italicize the placeholder text */
        }
    </style>
</head>
<body>
    <?php require 'utils/header3.php'; ?><!-- Header content. File found in utils folder -->

    <div class="content"><!-- Body content holder -->
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <!-- Login Form -->
                <h2>Login</h2>
                <form action="index.php" class="form-group" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-default" >Login</button>
                </form>

                <br>
                <p>Don't have an account? <a href="regfirst.php">Register here</a></p>

                <br>
                <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> HOME</a>
            </div>
        </div>
    </div>
    <br>
    <?php require 'utils/footer.php'; ?><!-- Footer content. File found in utils folder -->
</body>
</html>
