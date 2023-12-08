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


$ce_num = $_POST['ce_num'];
$uin = $_SESSION['uin']; 
$status = $_POST['status'];
$semester = $_POST['semester'];
$year = $_POST['year'];

$sql = "UPDATE class_enrollment SET Status=?, Semester=?, Year=? WHERE CE_Num=? AND UIN=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssiii", $status, $semester, $year, $ce_num, $uin);

if ($stmt->execute()) {
    echo "Class enrollment record updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
