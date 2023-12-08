<?php
// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "2001";
$dbname = "310_db";
// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if()
    $programName = $_POST["ProgramName"];
    $programDesc = $_POST["ProgramDesc"];

    $stmt = $conn->prepare("INSERT INTO programs (Name, Description) VALUES (?, ?)");
    $stmt->bind_param("ss", $programName, $programDesc);
    $stmt->execute();
    
    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "New Program created successfully";
    }
    $stmt->close();
    
}
$conn->close();
header("Location: ProgramInfoManagement.php");
?>