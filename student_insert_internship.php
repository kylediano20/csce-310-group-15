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
$intern_id = $_POST['intern_id'];
$status = $_POST['status'];
$year = $_POST['year'];

$sql = "INSERT INTO intern_app (UIN, Intern_ID, Status, Year) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisi", $uin, $intern_id, $status, $year);

if ($stmt->execute()) {
    echo "Internship application record added successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
