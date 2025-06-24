<?php
include_once 'db1.php';

// Check if the sort parameter is set and valid
$valid_columns = ['event_title', 'participents', 'event_price', 'st_name', 'name', 'Date', 'time', 'location'];
$sort_by = isset($_GET['sort_by']) && in_array($_GET['sort_by'], $valid_columns) ? $_GET['sort_by'] : 'event_title';

// Using validated column name directly in the query for sorting
$query = "SELECT e.event_id, e.event_title, e.participents, e.event_price, st.st_name, s.name, DATE_FORMAT(ef.Date, '%d-%m-%Y') AS Date, ef.time, ef.location 
          FROM staff_coordinator s, event_info ef, student_coordinator st, events e 
          WHERE e.event_id = ef.event_id AND e.event_id = s.event_id AND e.event_id = st.event_id 
          ORDER BY $sort_by";
$result = mysqli_query($conn, $query);

// Fetch data for the chart (number of participants per event)
$chart_data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $chart_data[] = [
        'event_title' => $row['event_title'],
        'participents' => (int) $row['participents']
    ];
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Preranothsava_adminPage</title>
    <!-- Add necessary CSS or other header content -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include 'utils/adminHeader.php' ?>

    <div class="content">
        <div class="container">
            <h1>EVENT DETAILS</h1>
            
            <!-- Displaying the chart -->
            <div>
                <canvas id="participantsChart" width="400" height="200"></canvas>
                <script>
                    var ctx = document.getElementById('participantsChart').getContext('2d');
                    var chartData = <?php echo json_encode($chart_data); ?>;
                    
                    var eventTitles = chartData.map(function(item) {
                        return item.event_title;
                    });

                    var participantsCount = chartData.map(function(item) {
                        return item.participents;
                    });

                    var participantsChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: eventTitles,
                            datasets: [{
                                label: 'Number of Participants',
                                data: participantsCount,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>

            <?php if (mysqli_num_rows($result) > 0) { ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><a href="?sort_by=event_title">Event Name</a></th>
                            <th><a href="?sort_by=participents">No. of Participants</a></th>
                            <th><a href="?sort_by=event_price">Price</a></th>
                            <th><a href="?sort_by=st_name">Student Co-ordinator</a></th>
                            <th><a href="?sort_by=name">Staff Co-ordinator</a></th>
                            <th><a href="?sort_by=Date">Date</a></th>
                            <th><a href="?sort_by=time">Time</a></th>
                            <th><a href="?sort_by=location">Location</a></th>
                            <th>Actions</th>
                            <th>    </th> 
                            <th>Send Reminder</th> <!-- New column for sending reminder -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Rewind the result set to start displaying the data again
                        mysqli_data_seek($result, 0);
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $formatted_time = date('h:i A', strtotime($row['time']));

                            // Fetch feedback for the event
                            $event_id = $row['event_id'];
                            $feedback_query = "SELECT COUNT(*) as feedback_count, AVG(rating) as average_rating FROM event_feedback WHERE event_id = $event_id";
                            $feedback_result = mysqli_query($conn, $feedback_query);
                            $feedback_data = mysqli_fetch_assoc($feedback_result);
                            $feedback_count = $feedback_data['feedback_count'];
                            $average_rating = round($feedback_data['average_rating'], 1);
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['event_title']); ?></td>
                                <td><?php echo htmlspecialchars($row['participents']); ?></td>
                                <td><?php echo htmlspecialchars($row['event_price']); ?></td>
                                <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                <td><?php echo htmlspecialchars($formatted_time); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><a class="edit" href="editEvent.php?id=<?php echo $row['event_id']; ?>">Edit</a></td>
                                <td><a class="delete" href="deleteEvent.php?id=<?php echo $row['event_id']; ?>">Delete</a></td>
                                
                                <!-- Feedback Column -->
                                <!-- <td>
                                    <a href="view_feedback.php?event_id=<?php echo $event_id; ?>">View Feedback (<?php echo $feedback_count; ?>)</a><br>
                                    <?php if ($feedback_count > 0) { ?>
                                        <span>Average Rating: <?php echo $average_rating; ?> / 5</span>
                                    <?php } else { ?>
                                        <span>No feedback yet</span>
                                    <?php } ?>
                                </td> -->

                                <!-- Send Reminder Column -->
                                <td>
                                    <form action="send_reminder.php" method="POST">
                                        <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                                        <button type="submit" name="send_reminder" class="btn btn-warning">Send Reminder</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p>No events found.</p>
            <?php } ?>
            <br><br> <a class="btn btn-default" href="createEventForm.php">Create Event</a><br><br><br><br>
        </div>
        <a class="btn btn-default" href="Stu_details.php"><span class="glyphicon glyphicon-circle-arrow-right"></span> Student details</a>
        <a class="btn btn-default" href="Stu_cordinator.php"><span class="glyphicon glyphicon-circle-arrow-right"></span> Student Co-ordinator details</a>
        <a class="btn btn-default" href="Staff_cordinator.php"><span class="glyphicon glyphicon-circle-arrow-right"></span> Staff Co-ordinator details</a>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>

</html>

