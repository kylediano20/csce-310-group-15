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
    $applicationNumber = $_POST['applicationNumber'];
    $documentLink = $_POST['documentLink'];
    $documentType = $_POST['documentType'];

    // Insert into documents table
    $stmt = $conn->prepare("INSERT INTO documentation (App_Num, Link, Doc_Type) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $applicationNumber, $documentLink, $documentType);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Document uploaded successfully";
    }
    $stmt->close();
}

$conn->close();

header("Location: StudentDocumentManagement.php");
?>