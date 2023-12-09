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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uin = $_POST['uin'];
    $programNum = $_POST['programNum'];
    $startDate = $_POST['startDate'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $endDate = $_POST['endDate'];
    $eventType = $_POST['eventType'];

    // Insert into Event table
    $stmt = $conn->prepare("INSERT INTO events (UIN, Program_Num, Start_Date, Time, Location, End_Date, Event_Type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssss", $uin, $programNum, $startDate, $time, $location, $endDate, $eventType);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "New event created successfully";
    }
    $stmt->close();
}
$conn->close();
header("Location: AdminEventManagement.php");
?>