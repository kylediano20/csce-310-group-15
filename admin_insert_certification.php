<?php
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

$uin = $_POST['uin'];
$cert_id = $_POST['cert_id'];
$status = $_POST['status'];
$training_status = $_POST['training_status'];
$program_num = $_POST['program_num'];
$semester = $_POST['semester'];
$year = $_POST['year'];

// Prepare an insert statement
$sql = "INSERT INTO cert_enrollment (UIN, Cert_ID, Status, Training_Status, Program_Num, Semester, Year) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Bind variables to the prepared statement as parameters
$stmt->bind_param("iissisi", $uin, $cert_id, $status, $training_status, $program_num, $semester, $year);

// Attempt to execute the prepared statement
if ($stmt->execute()) {
    echo "New certification enrollment record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
