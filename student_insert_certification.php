<?php
session_start();
// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "Temporary12@";
$dbname = "310_db";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uin = $_SESSION['uin'];
$cert_id = $_POST['cert_id'];
$status = $_POST['status'];
$training_status = $_POST['training_status'];
$program_num = $_POST['program_num'];
$semester = $_POST['semester'];
$year = $_POST['year'];

$sql = "INSERT INTO cert_enrollment (UIN, Cert_ID, Status, Training_Status, Program_Num, Semester, Year) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissisi", $uin, $cert_id, $status, $training_status, $program_num, $semester, $year);

if ($stmt->execute()) {
    echo "Certification enrollment record added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
