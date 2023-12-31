<?php
// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "sys";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchEventDetails($eventID) {
    global $conn;

    $selectStmt = $conn->prepare("SELECT Start_Date, Time, Location, End_Date, Event_Type FROM events WHERE Event_ID = ?");
    $selectStmt->bind_param("s", $eventID);
    $selectStmt->execute();
    $selectResult = $selectStmt->get_result();
    $editEventData = $selectResult->fetch_assoc();
    $selectStmt->close();

    return $editEventData;
}

function updateEventDetails($eventID, $startDate, $time, $location, $endDate, $eventType) {
    global $conn;

    $stmt = $conn->prepare("UPDATE events SET Start_Date = ?, Time = ?, Location = ?, End_Date = ?, Event_Type = ? WHERE Event_ID = ?");
    $stmt->bind_param("ssssss", $startDate, $time, $location, $endDate, $eventType, $eventID);
    $stmt->execute();

    $success = $stmt->affected_rows > 0;
    
    $stmt->close();

    return $success;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST['editEventID'];
    $updateStartDate = $_POST['updateStartDate'];
    $updateTime = $_POST['updateTime'];
    $updateLocation = $_POST['updateLocation'];
    $updateEndDate = $_POST['updateEndDate'];
    $updateEventType = $_POST['updateEventType'];

    $editEventData = fetchEventDetails($eventID);

    // Output only JSON, no HTML content before or after
    header('Content-Type: application/json');

    $editEventData = fetchEventDetails($eventID);

    // Output only JSON, no HTML content before or after
    header('Content-Type: application/json');

    if ($editEventData) {
        $updateSuccess = updateEventDetails($eventID, $updateStartDate, $updateTime, $updateLocation, $updateEndDate, $updateEventType);

        if ($updateSuccess) {
            echo json_encode(['message' => 'Event updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update event']);
        }
    } else {
        echo json_encode(['error' => 'Event not found']);
        exit();
    }
    exit();
}

$conn->close();
header("Location: AdminEventManagement.php");

?>