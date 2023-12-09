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

$sql = "DELETE FROM cert_enrollment WHERE CertE_Num=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $certe_num);

if ($stmt->execute()) {
    echo "Certification enrollment record deleted successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>