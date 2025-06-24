<?php
session_start();
include_once 'db1.php';

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Fetch current event data
    $stmt = $conn->prepare("SELECT e.event_id, e.event_title, e.event_price, e.img_link, e.type_id, e.rules, e.dept, ei.Date, ei.time, ei.location, sc.name AS staff_name, sc.phone AS staff_phone, st.st_name AS student_name, st.st_phone AS student_phone 
                            FROM events e 
                            JOIN event_info ei ON e.event_id = ei.event_id 
                            JOIN staff_coordinator sc ON e.event_id = sc.event_id 
                            JOIN student_coordinator st ON e.event_id = st.event_id 
                            WHERE e.event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_title = $_POST["event_title"];
    $dept = $_POST["dept"];
    $event_price = $_POST["event_price"];
    $img_link = $_POST["img_link"];
    $type_id = $_POST["type_id"];
    $Date = $_POST["Date"];
    $time = $_POST["time"];
    $location = $_POST["location"];
    $sname = $_POST["sname"];
    $phone = $_POST["phone"];
    $st_name = $_POST["st_name"];
    $st_phone = $_POST["st_phone"];
    $rules = $_POST["rules"];

    // Basic validation for phone numbers
    if (!preg_match('/^[0-9]{10}$/', $phone) || !preg_match('/^[0-9]{10}$/', $st_phone)) {
        echo "<script>
              alert('Please enter valid 10-digit phone numbers.');
              window.location.href='editEventForm.php?id=$event_id';
              </script>";
        exit();
    }

    $conn->begin_transaction();
    try {
        $stmt1 = $conn->prepare("UPDATE events SET event_title = ?, event_price = ?, img_link = ?, type_id = ?, rules = ?, dept = ? WHERE event_id = ?");
        $stmt1->bind_param("sdsdssi", $event_title, $event_price, $img_link, $type_id, $rules, $dept, $event_id);
        $stmt1->execute();

        $stmt2 = $conn->prepare("UPDATE event_info SET Date = ?, time = ?, location = ? WHERE event_id = ?");
        $stmt2->bind_param("sssi", $Date, $time, $location, $event_id);
        $stmt2->execute();

        $stmt3 = $conn->prepare("UPDATE staff_coordinator SET name = ?, phone = ? WHERE event_id = ?");
        $stmt3->bind_param("ssi", $sname, $phone, $event_id);
        $stmt3->execute();

        $stmt4 = $conn->prepare("UPDATE student_coordinator SET st_name = ?, st_phone = ? WHERE event_id = ?");
        $stmt4->bind_param("ssi", $st_name, $st_phone, $event_id);
        $stmt4->execute();

        $conn->commit();
        echo "<script>
              alert('Event Updated Successfully!');
              window.location.href='adminPage.php';
              </script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>
              alert('Event update failed: " . $conn->error . "');
              window.location.href='editEventForm.php?id=$event_id';
              </script>";
    }

    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
    $stmt4->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <?php require 'utils/styles.php'; ?>
</head>
<body>
    <?php require 'utils/adminHeader.php'; ?>
    <form method="POST">
        <div class="container">
            <h1>Edit Event</h1>
            <hr>
            <label>Event ID:</label><br>
            <input type="number" name="event_id" value="<?php echo $event['event_id']; ?>" readonly class="form-control"><br><br>
            
            <label>Event Name:</label><br>
            <input type="text" name="event_title" required class="form-control" value="<?php echo $event['event_title']; ?>"><br><br>

            <label>Organized by:</label><br>
            <input type="text" name="dept" required class="form-control" value="<?php echo $event['dept']; ?>"><br><br>

            <label>Event Price:</label><br>
            <input type="number" name="event_price" required class="form-control" value="<?php echo $event['event_price']; ?>"><br><br>

            <label>Upload Path to Image:</label><br>
            <input type="text" name="img_link" required class="form-control" value="<?php echo $event['img_link']; ?>"><br><br>

            <label>Type ID:</label><br>
            <input type="number" name="type_id" required class="form-control" value="<?php echo $event['type_id']; ?>"><br><br>

            <label>Event Date:</label><br>
            <input type="date" name="Date" required class="form-control" value="<?php echo $event['Date']; ?>"><br><br>

            <label>Event Time:</label><br>
            <input type="time" name="time" required class="form-control" value="<?php echo $event['time']; ?>"><br><br>

            <label>Event Location:</label><br>
            <input type="text" name="location" required class="form-control" value="<?php echo $event['location']; ?>"><br><br>

            <label>Staff Co-ordinator Name:</label><br>
            <input type="text" name="sname" required class="form-control" value="<?php echo $event['staff_name']; ?>"><br><br>

            <label>Staff Co-ordinator Phone number:</label><br>
            <input type="text" name="phone" required class="form-control" value="<?php echo $event['staff_phone']; ?>"><br><br>

            <label>Student Co-ordinator Name:</label><br>
            <input type="text" name="st_name" required class="form-control" value="<?php echo $event['student_name']; ?>"><br><br>

            <label>Student Co-ordinator Phone number:</label><br>
            <input type="text" name="st_phone" required class="form-control" value="<?php echo $event['student_phone']; ?>"><br><br>

            <div class="form-group">
                <label for="rules">Rules and Regulations:</label>
                <textarea id="rules" name="rules" required class="form-control"><?php echo $event['rules']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-default pull-right">Update Event <span class="glyphicon glyphicon-send"></span></button>
            <a class="btn btn-default navbar-btn" href="adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
        </div>
    </form>
    <?php require 'utils/footer.php'; ?>
    <a class="btn btn-default navbar-btn" href="adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
</body>
</html>
