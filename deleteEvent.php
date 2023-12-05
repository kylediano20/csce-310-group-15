<?php
// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "jtsr101";
$dbname = "310_db";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form data is set
    if (isset($_POST["deleteEventID"])) {
        $eventID = $_POST["deleteEventID"];

        // Delete the event from the event_tracking table
        $deleteTrackingQuery = "DELETE FROM event_tracking WHERE Event_ID = ?";
        $stmtTracking = $conn->prepare($deleteTrackingQuery);
        $stmtTracking->bind_param("i", $eventID);
        $stmtTracking->execute();
        $stmtTracking->close();

        // Delete the event from the events table
        $deleteEventQuery = "DELETE FROM events WHERE Event_ID = ?";
        $stmtEvent = $conn->prepare($deleteEventQuery);
        $stmtEvent->bind_param("i", $eventID);
        $stmtEvent->execute();
        $stmtEvent->close();
        header("Location: AdminEventManagement.php");

        exit();
    }
}

$conn->close();
?>