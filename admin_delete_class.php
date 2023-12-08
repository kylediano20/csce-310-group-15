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

$ce_num = $_POST['ce_num'];

$sql = "DELETE FROM class_enrollment WHERE CE_NUM=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ce_num);

if ($stmt->execute()) {
    echo "Class enrollment record deleted successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
