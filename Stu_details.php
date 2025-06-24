<?php
include_once 'db1.php';

// Query to fetch student details along with their registered events, ordered by student USN and event title
$result = mysqli_query($conn, "
    SELECT p.usn, p.name, p.branch, p.sem, p.email, p.phone, p.college, e.event_title
    FROM events e
    JOIN registered r ON e.event_id = r.event_id
    JOIN participent p ON r.usn = p.usn
    ORDER BY p.usn ASC, e.event_title ASC
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
            <h1>STUDENT DETAILS</h1>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>USN</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Sem</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>College</th>
                            <th>Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $currentUsn = null;
                        while ($row = mysqli_fetch_array($result)):
                            ?>
                            <tr>
                                <?php if ($row["usn"] !== $currentUsn): ?>
                                    <td><?php echo htmlspecialchars($row["usn"], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row["branch"], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row["sem"], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars($row["college"], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <?php $currentUsn = $row["usn"]; ?>
                                <?php else: ?>
                                    <td colspan="7"></td>
                                <?php endif; ?>
                                <td><?php echo htmlspecialchars($row["event_title"], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No student details found</p>
            <?php endif; ?>
        </div>
        <a class="btn btn-default" href="adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> HOME</a>
        <a class="btn btn-default" href="Stu_cordinator.php"><span class="glyphicon glyphicon-circle-arrow-right"></span> Student Co-ordinator details</a>
        <a class="btn btn-default" href="Staff_cordinator.php"><span class="glyphicon glyphicon-circle-arrow-right"></span> Staff_cordinator details</a>
    </div>
    <br>
    <br>
    <?php include 'utils/footer.php'; ?>
</body>

</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
