<?php
require 'db1.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Prepare statements for each deletion
        $stmt1 = $conn->prepare("DELETE FROM events WHERE event_id = ?");
        $stmt2 = $conn->prepare("DELETE FROM event_info WHERE event_id = ?");
        $stmt3 = $conn->prepare("DELETE FROM staff_coordinator WHERE event_id = ?");
        $stmt4 = $conn->prepare("DELETE FROM student_coordinator WHERE event_id = ?");
        $stmt5 = $conn->prepare("DELETE FROM registered WHERE event_id = ?");

        // Bind the id parameter and execute each statement
        $stmt1->bind_param("i", $id);
        $stmt2->bind_param("i", $id);
        $stmt3->bind_param("i", $id);
        $stmt4->bind_param("i", $id);
        $stmt5->bind_param("i", $id);

        $stmt1->execute();
        $stmt2->execute();
        $stmt3->execute();
        $stmt4->execute();
        $stmt5->execute();

        // Commit transaction
        $conn->commit();

        echo "<script>
            alert('Event Deleted Successfully');
            window.location.href='adminPage.php';
            </script>";

    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $conn->rollback();
        echo "Error deleting record: " . $e->getMessage();
    }

    // Close statements
    $stmt1->close();
    $stmt2->close();
    $stmt3->close();
    $stmt4->close();
    $stmt5->close();
} else {
    echo "No event ID specified.";
}

$conn->close();
?>
