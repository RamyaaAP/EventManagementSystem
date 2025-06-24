<?php
include_once 'db1.php';

// Query to fetch student coordinator details with associated event titles
$result = mysqli_query($conn, "
    SELECT s.st_name, s.st_phone, e.event_title, e.event_id
    FROM student_coordinator s
    JOIN events e ON e.event_id = s.event_id
");

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Preranothsava_adminPage</title>
    <?php require 'utils/styles.php'; ?> <!-- CSS links. File found in utils folder -->
</head>

<body>
    <?php include 'utils/adminHeader.php'; ?>
    <div class="content">
        <div class="container">
            <h1>STUDENT CO-ORDINATOR DETAILS</h1>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="table table-hover">
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Event</th>
                            <th></th> <!-- Update button column -->
                        </tr>
                        <?php while ($row = mysqli_fetch_array($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row["st_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["st_phone"]); ?></td>
                                <td><?php echo htmlspecialchars($row["event_title"]); ?></td>
                                <td><a href="updateStudent.php?id=<?php echo $row['event_id']; ?>" class="btn btn-default">Update</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No student coordinator details found</p>
            <?php endif; ?>
        </div>
        <a class="btn btn-default" href="adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> HOME</a>
        <a class="btn btn-default" href="Stu_details.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Student details</a>
        <a class="btn btn-default" href="Staff_cordinator.php"><span class="glyphicon glyphicon-circle-arrow-right"></span> Staff Co-ordinator details</a>
    </div>
    <?php include 'utils/footer.php'; ?>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
