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
$certe_num = $_POST['certe_num'];
$uin = $_POST['uin']; // Added UIN
$status = $_POST['status'];
$training_status = $_POST['training_status'];
$program_num = $_POST['program_num'];
$semester = $_POST['semester'];
$year = $_POST['year'];

$sql = "UPDATE cert_enrollment SET Status=?, Training_Status=?, Program_Num=?, Semester=?, Year=? WHERE CertE_Num=? AND UIN=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisiii", $status, $training_status, $program_num, $semester, $year, $certe_num, $uin);

if ($stmt->execute()) {
    echo "Certification enrollment record updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
