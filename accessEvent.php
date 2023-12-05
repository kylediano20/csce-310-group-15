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
    $eventID = $_POST['accessEventID']; 

    $stmt = $conn->prepare("SELECT * FROM events WHERE EVENT_ID = ?");
    $stmt->bind_param("s", $eventID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Return the event rows as JSON
        header('Content-Type: application/json');
        echo json_encode($row);
        exit();
    } else {
        echo "Event not found!";
    }

    $stmt->close();
}

$conn->close();
header("Location: AdminEventManagement.php");

?>
