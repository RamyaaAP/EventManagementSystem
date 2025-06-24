<?php
session_start();
include_once 'db1.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Preranothsava</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        .form-control::placeholder {
            color: #ccc;
            font-style: italic;
        }
        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php require 'utils/adminHeader.php'; ?>
    <form method="POST">
        <div class="w3-container">
            <div class="content">
                <div class="container">
                    <div class="col-md-6 col-md-offset-3">
                        <h1>CREATE EVENT</h1>
                        <hr>
                        <label>Event ID:</label><br>
                        <input type="number" name="event_id" required class="form-control" placeholder="Enter Event ID"><br><br>
                        
                        <label>Event Name:</label><br>
                        <input type="text" name="event_title" required class="form-control" placeholder="Enter Event Name"><br><br>

                        <label for="dept">Organized by:</label><br>
                        <input type="text" id="dept" name="dept" required class="form-control" placeholder="Enter Department" oninput="this.value = this.value.toUpperCase()"><br><br>

                        <label>Event Price:</label><br>
                        <input type="number" name="event_price" required class="form-control" placeholder="Enter Event Price"><br><br>

                        <!-- <label>Upload Path to Image:</label><br>
                        <input type="text" name="img_link" required class="form-control" placeholder="Enter Image Path"><br><br> -->

                        <label>Type_ID:</label><br>
                        <input type="number" name="type_id" required class="form-control" placeholder="Enter Type ID"><br><br>

                        <label>Event Date:</label><br>
                        <input type="date" name="Date" required class="form-control"><br><br>

                        <label>Event Time:</label><br>
                        <input type="time" name="time" required class="form-control"><br><br>

                        <label>Event Location:</label><br>
                        <input type="text" name="location" required class="form-control" placeholder="Enter Location"><br><br>

                        <label>Staff Co-ordinator Name:</label><br>
                        <input type="text" name="sname" required class="form-control" placeholder="Enter Staff Co-ordinator Name"><br><br>

                        <label>Staff Co-ordinator Phone number:</label><br>
                        <input type="text" name="phone" required class="form-control" placeholder="Enter Enter 10 digit Phone number"><br><br>

                        <label>Student Co-ordinator Name:</label><br>
                        <input type="text" name="st_name" required class="form-control" placeholder="Enter Student Co-ordinator Name"><br><br>

                        <label>Student Co-ordinator Phone number:</label><br>
                        <input type="text" name="st_phone" required class="form-control" placeholder="Enter Enter 10 digit Phone number"><br><br>

                        <style>
                            .form-group {
                                max-width: 600px;
                                margin-bottom: 20px;
                            }
                            .form-group label {
                                display: block;
                                margin-bottom: 5px;
                            }
                            .form-group textarea {
                                width: 100%;
                                height: 200px;
                                padding: 10px;
                                font-size: 14px;
                                line-height: 1.5;
                                border: 1px solid #ccc;
                                border-radius: 4px;
                                box-sizing: border-box;
                                resize: vertical;
                            }
                        </style>

                        <div class="form-group">
                            <label for="rules">Rules and Regulations:</label>
                            <textarea id="rules" name="rules" required class="form-control" placeholder="Enter rules and regulations here..."></textarea>
                        </div>

                        <!-- Dropdown for selecting event category -->
                        <label>Event Category:</label><br>
                        <select name="event_category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="Technical">Technical</option>
                            <option value="Gaming">Gaming</option>
                            <option value="On-Stage">On-Stage</option>
                            <option value="Sports Event">Off-Stage</option>
                        </select><br><br>

                        <button type="submit" name="update" class="btn btn-default pull-right">Create Event <span class="glyphicon glyphicon-send"></span></button>
                        <a class="btn btn-default navbar-btn" href="adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php require 'utils/footer.php'; ?>
</body>
</html>

<?php
if (isset($_POST["update"])) {
    $event_id = $_POST["event_id"];
    $event_title = $_POST["event_title"];
    $dept = $_POST["dept"];
    $event_price = $_POST["event_price"];
    $img_link = $_POST["img_link"];
    $type_id = $_POST["type_id"];
    $sname = $_POST["sname"];
    $phone = $_POST["phone"];
    $st_name = $_POST["st_name"];
    $st_phone = $_POST["st_phone"];
    $Date = $_POST["Date"];
    $time = $_POST["time"];
    $location = $_POST["location"];
    $rules = $_POST["rules"];
    $event_category = $_POST["event_category"];

    // Basic validation for phone numbers and dates
    if (!preg_match('/^[0-9]{10}$/', $phone) || !preg_match('/^[0-9]{10}$/', $st_phone)) {
        echo "<script>
              alert('Please enter valid 10-digit phone numbers.');
              window.location.href='createEventForm.php';
              </script>";
        exit();
    }

    if (!empty($event_id) && !empty($event_title) && !empty($event_price) && !empty($img_link) && !empty($type_id)) {
        include 'db1.php';

        // Using prepared statements to prevent SQL injection
        $conn->begin_transaction();
        try {
            // Insert event into the events table with the selected category
            $stmt1 = $conn->prepare("INSERT INTO events (event_id, event_title, event_price, img_link, type_id, rules, dept, category) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt1->bind_param("isdsdsss", $event_id, $event_title, $event_price, $img_link, $type_id, $rules, $dept, $event_category);
            $stmt1->execute();

            $stmt2 = $conn->prepare("INSERT INTO event_info (event_id, Date, time, location) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("isss", $event_id, $Date, $time, $location);
            $stmt2->execute();            

            $stmt3 = $conn->prepare("INSERT INTO student_coordinator (sid, st_name, st_phone, event_id) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("isii", $event_id, $st_name, $st_phone, $event_id);
            $stmt3->execute();

            $stmt4 = $conn->prepare("INSERT INTO staff_coordinator (stid, name, phone, event_id) VALUES (?, ?, ?, ?)");
            $stmt4->bind_param("isis", $event_id, $sname, $phone, $event_id);
            $stmt4->execute();

            $conn->commit();
            echo "<script>
                  alert('Event Inserted Successfully!');
                  window.location.href='adminPage.php';
                  </script>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "<script>
                  alert('Event insertion failed: " . $conn->error . "');
                  window.location.href='createEventForm.php';
                  </script>";
        }

        $stmt1->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
        $conn->close();
    } else {
        echo "<script>
              alert('All fields are required');
              window.location.href='createEventForm.php';
              </script>";
    }
}
?>
