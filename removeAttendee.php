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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST['removeEventAttendeeID']; 
    $uin = $_POST['removeEventUIN']; 

    $stmt = $conn->prepare("DELETE FROM event_tracking WHERE Event_ID = ? AND UIN = ?;");
    $stmt->bind_param("ii", $eventID, $uin);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Attendee created successfully";
    }
    $stmt->close();
}

$conn->close();
header("Location: AdminEventManagement.php");
?>