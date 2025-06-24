<?php
include_once 'db1.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = mysqli_query($conn, "SELECT * FROM staff_coordinator s ,events e WHERE e.event_id = s.event_id");
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Preranothsava_adminPage</title>
    <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
</head>

<body>
    <?php include 'utils/adminHeader.php'; ?>
    <div class="content">
        <div class="container">
            <h1>STAFF CO-ORDINATOR DETAILS</h1>
            <?php
            if (mysqli_num_rows($result) > 0) {
            ?>
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Event</th>
                        <th></th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                            <td><?php echo htmlspecialchars($row["event_title"]); ?></td>
                            <td><a href="updateStaff.php?id=<?php echo $row['event_id']; ?>" class="btn btn-default">Update</a></td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            <?php
            } else {
                echo "<p>No Staff coordinator details found</p>";
            }
            ?>
        </div>
        <a class="btn btn-default" href="adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> HOME</a>
        <a class="btn btn-default" href="Stu_details.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Student details</a>
        <a class="btn btn-default" href="Stu_cordinator.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Student Co-ordinator details</a>
    </div>
    <?php include 'utils/footer.php'; ?>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
