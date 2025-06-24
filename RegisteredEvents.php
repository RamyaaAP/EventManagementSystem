<?php
require_once 'utils/header3.php';
require_once 'utils/styles.php';

// Validate and sanitize input
$usn = isset($_POST['usn']) ? $_POST['usn'] : '';
$usn = trim($usn); // Trim whitespace

if (empty($usn)) {
    echo "<div class='content'><div class='container'><p>Please enter a valid USN.</p></div></div>";
    include 'utils/footer.php';
    exit; // Stop further execution
}

include_once 'classes/db1.php';

// Function to sanitize data
function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, $data);
}

// Registered events query
$registered_query = "
    SELECT 
        e.event_title, st.st_name, s.name, ef.Date, ef.time, ef.location
    FROM 
        registered r
        JOIN events e ON r.event_id = e.event_id
        JOIN event_info ef ON e.event_id = ef.event_id
        JOIN staff_coordinator s ON e.event_id = s.event_id
        JOIN student_coordinator st ON e.event_id = st.event_id
    WHERE 
        r.usn = '" . sanitize($conn, $usn) . "'
";

$registered_result = mysqli_query($conn, $registered_query);

// Not registered events query
$not_registered_query = "
    SELECT 
        e.event_title, st.st_name, s.name, ef.Date, ef.time, ef.location
    FROM 
        events e
        JOIN event_info ef ON e.event_id = ef.event_id
        JOIN staff_coordinator s ON e.event_id = s.event_id
        JOIN student_coordinator st ON e.event_id = st.event_id
    WHERE 
        e.event_id NOT IN (SELECT event_id FROM registered WHERE usn = '" . sanitize($conn, $usn) . "')
";

$not_registered_result = mysqli_query($conn, $not_registered_query);

?>

<div class="content">
    <div class="container">
        <h1>Registered Events</h1>
        <?php if (mysqli_num_rows($registered_result) > 0): ?> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>             
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($registered_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['event_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['time']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Not Yet Registered for any events</p>
        <?php endif; ?>
    </div>
</div>

<div class="content">
    <div class="container">
        <h1>Not Registered Events</h1>
        <?php if (mysqli_num_rows($not_registered_result) > 0): ?> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>             
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_array($not_registered_result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['event_title']); ?></td>
                            <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['time']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No events available</p>
        <?php endif; ?>
        <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> HOME</a>
        <a class="btn btn-default" href="register.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Click here to register other events</a>
    </div>
</div>

<?php include 'utils/footer.php'; ?>

<?php
// Close the database connection
mysqli_close($conn);
?>
