<?php
session_start();
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
$uin = $_SESSION['uin'];
$class_id = $_POST['class_id'];
$status = $_POST['status'];
$semester = $_POST['semester'];
$year = $_POST['year'];

$sql = "INSERT INTO class_enrollment (UIN, Class_ID, Status, Semester, Year) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissi", $uin, $class_id, $status, $semester, $year);

if ($stmt->execute()) {
    echo "Class enrollment record added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
