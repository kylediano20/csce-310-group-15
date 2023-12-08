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


$ia_num = $_POST['ia_num'];

$sql = "DELETE FROM intern_app WHERE IA_Num=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ia_num);

if ($stmt->execute()) {
    echo "Internship application record deleted successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
