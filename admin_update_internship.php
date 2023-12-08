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

$ia_num = $_POST['ia_num'];
$uin = $_POST['uin']; // Added UIN
$status = $_POST['status'];
$year = $_POST['year'];

$sql = "UPDATE intern_app SET Status=?, Year=? WHERE IA_Num=? AND UIN=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siii", $status, $year, $ia_num, $uin);

if ($stmt->execute()) {
    echo "Internship application record updated successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
