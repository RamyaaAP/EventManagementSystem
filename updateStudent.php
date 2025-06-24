<?php
include_once 'db1.php';

// Retrieve the 'id' parameter from GET request
$id = $_GET['id'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Preranothsava - Update Student Coordinator</title>
    <?php require 'utils/styles.php'; ?> <!-- CSS links. File found in utils folder -->
</head>
<body>
<?php include 'utils/adminHeader.php'; ?>
    <div class="content">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <form method="POST">
                    <label>Student Coordinator Name</label><br>
                    <input type="text" name="st_name" required class="form-control"><br><br>
                    <label>Student Coordinator Phone</label><br>
                    <input type="text" name="st_phone" required class="form-control"><br><br>
                    <button type="submit" name="update" class="btn btn-default">Update</button>
                </form>
            </div>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>
</body>
</html>

<?php
if (isset($_POST["update"])) {
    $name = $_POST["st_name"];
    $phone = $_POST["st_phone"];

    // Sanitize inputs (assuming $conn is your database connection)
    $name = mysqli_real_escape_string($conn, $name);
    $phone = mysqli_real_escape_string($conn, $phone);

    // SQL query to update student coordinator details
    $sql = "UPDATE student_coordinator SET st_name='$name', st_phone='$phone' WHERE sid='$id'";

    if ($conn->query($sql) === true) {
        echo "<script>
                alert('Updated Successfully');
                window.location.href = 'stu_cordinator.php';
              </script>";
    } else {
        echo "<script>
                alert('Update failed: " . $conn->error . "');
                window.location.href = 'updateStudent.php?id=$id'; // Redirect to the update form with the same id
              </script>";
    }
}
?>
