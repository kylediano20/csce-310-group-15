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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uinToDelete = $_POST["AppDelete"];

    $stmt = $conn->prepare("DELETE FROM applications WHERE UIN = ?");
    $stmt->bind_param("i", $uinToDelete);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Applications deleted successfully";
    }

    $stmt->close();
}

$conn->close();
header("Location: ApplicationInformationManagement.php");
?>