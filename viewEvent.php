<?php
require 'db1.php';

// Retrieve the category from the URL
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

// Query to fetch events based on the category
$result = mysqli_query($conn, "SELECT * FROM events 
                               INNER JOIN event_info ef ON events.event_id = ef.event_id 
                               INNER JOIN student_coordinator s ON events.event_id = s.event_id 
                               INNER JOIN staff_coordinator st ON events.event_id = st.event_id 
                               WHERE category = '$category'");
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>Preranothsava - <?php echo ucfirst($category); ?> Events</title>
    <?php require 'utils/styles.php'; ?><!-- CSS links. File found in utils folder -->

</head>
<body>
    <?php require 'utils/header2.php'; ?><!-- Header content. File found in utils folder -->
    
    <div class="content"><!-- Body content holder -->
        <div class="container">
            <div class="col-md-12"><!-- Full width content holder -->
                <h1 style="color:#003300; font-size:38px;"><u><strong><?php echo ucfirst($category); ?> Events</strong></u></h1>

                <?php
                // Check if there are events in the selected category
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each event and display it
                    while ($row = mysqli_fetch_array($result)) {
                        include 'events.php';  
                    }
                ?>
                    <div class="col-md-12">
                        <hr>
                    </div>
                <?php } else { ?>
                    <p>No events found in the <?php echo ucfirst($category); ?> category.</p>
                <?php } ?>
                
                <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
            </div><!-- End col-md-12 -->
        </div><!-- End container -->
    </div><!-- End content -->
    
    <?php require 'utils/footer.php'; ?><!-- Footer content. File found in utils folder -->
</body>
</html>
