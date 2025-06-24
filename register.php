<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Preranothsava - Register</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        .form-control::placeholder {
            color: #ccc;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (isset($_POST["register"])) {
        $usn = $_POST["usn"];
        $name = $_POST["name"];
        $branch = $_POST["branch"];
        $sem = $_POST["sem"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $college = $_POST["college"];
        $events = $_POST["events"];

        if (!empty($usn) && !empty($name) && !empty($branch) && !empty($sem) && !empty($email) && !empty($phone) && !empty($college) && !empty($events)) {
            include 'db1.php';

            $usn = $conn->real_escape_string($usn);
            $name = $conn->real_escape_string($name);
            $branch = $conn->real_escape_string($branch);
            $sem = (int) $sem;
            $email = $conn->real_escape_string($email);
            $phone = $conn->real_escape_string($phone);
            $college = $conn->real_escape_string($college);

            $check_query = "SELECT * FROM participent WHERE usn = '$usn'";
            $check_result = $conn->query($check_query);

            if ($check_result->num_rows > 0) {
                $participant = $check_result->fetch_assoc();
                $participant_id = $participant['id'];
            } else {
                $insert_participant = "INSERT INTO participent (usn, name, branch, sem, email, phone, college) 
                                      VALUES ('$usn', '$name', '$branch', $sem, '$email', '$phone', '$college')";
                
                if ($conn->query($insert_participant) === TRUE) {
                    $participant_id = $conn->insert_id;
                } else {
                    echo "<script>
                            alert('Failed to register participant.');
                            window.location.href='register.php';
                          </script>";
                    exit;
                }
            }

            $total_fee = 0;
            foreach ($events as $event_id) {
                $event_query = "SELECT event_title, entry_fee FROM events WHERE event_id = $event_id";
                $event_result = $conn->query($event_query);
                $event = $event_result->fetch_assoc();

                $event_name = $event['event_title'];
                $total_fee += $event['entry_fee'];

                $ticket_code = strtoupper(bin2hex(random_bytes(5)));

                $insert_registration = "INSERT INTO registered (participant_id, usn, event_id, event_name, date_registered, status, ticket_code, paid)
                                        VALUES ('$participant_id', '$usn', '$event_id', '$event_name', NOW(), 'confirmed', '$ticket_code', 'no')";
                
                if (!$conn->query($insert_registration)) {
                    echo "<script>
                            alert('Failed to register for event.');
                            window.location.href='register.php';
                          </script>";
                    exit;
                }
            }

            echo "<script>
                    alert('Registered Successfully! Proceed to payment.');
                    window.location.href = 'payment.php?usn=$usn&fee=$total_fee';
                  </script>";
            $conn->close();
        } else {
            echo "<script>
                    alert('All fields are required.');
                    window.location.href='register.php';
                  </script>";
        }
    }
    ?>
    <?php require 'utils/header3.php'; ?>
    <div class="content">
        <div class="container">
            <div class="col-md-6 col-md-offset-3">
                <h1 style="color:#000080; font-size:39px; font-weight:bold"><strong>Register:</strong></h1>
                <hr>
                <form method="POST" action="">
                    <label>Student USN:</label><br>
                    <input type="text" name="usn" class="form-control" placeholder="Enter Your USN" required><br>

                    <label>Student Name:</label><br>
                    <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required><br>

                    <label>Branch:</label><br>
                    <input type="text" name="branch" class="form-control" placeholder="Enter Your Branch" required><br>

                    <label>Semester:</label><br>
                    <input type="text" name="sem" class="form-control" placeholder="Enter Your Semester" required><br>

                    <label>Email:</label><br>
                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email" required><br>

                    <label>Phone:</label><br>
                    <input type="text" name="phone" class="form-control" placeholder="Enter Your Phone Number" required><br>

                    <label>College:</label><br>
                    <input type="text" name="college" class="form-control" placeholder="Enter Your College Name" required><br>

                    <label>Events:</label><br>
                    <?php
                    include 'db1.php';
                    $result = mysqli_query($conn, "SELECT event_id, event_title, event_price FROM events ORDER BY event_title ASC");
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<input type='checkbox' name='events[]' value='{$row['event_id']}' class='event-checkbox'> {$row['event_title']} - ₹ {$row['event_price']}<br>";
                    }
                    ?>
                    <br>
                    <div id="total-fee" style="font-weight: bold;">Total Entry Fee: Rs.0</div>
                    <script>
                        document.querySelectorAll('.event-checkbox').forEach(function(checkbox) {
                            checkbox.addEventListener('change', function() {
                                var totalFee = 0;
                                document.querySelectorAll('.event-checkbox:checked').forEach(function(checkedBox) {
                                    totalFee += parseFloat(checkedBox.parentNode.textContent.split('- ₹')[1]);
                                });
                                document.getElementById('total-fee').textContent = 'Total Entry Fee: ₹' + totalFee.toFixed(2);
                            });
                        });
                    </script>
                    <button type="submit" name="register" class="btn btn-primary">Submit</button><br><br>
                    <a href="usn.php"><u>Already registered?</u></a>
                </form>
                <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
            </div>
        </div>
    </div>
    <?php require 'utils/footer.php'; ?>
</body>
</html>
