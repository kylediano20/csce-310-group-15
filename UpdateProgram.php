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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedName = $_POST["ProgramNameUpdate"];
    $newName = $_POST["NewProgramName"];
    $description = $_POST["NewProgramDesc"];

    $stmt = $conn->prepare("UPDATE programs SET Name = ?, Description = ? WHERE Name = ?");
    $stmt->bind_param("sss", $newName, $description, $selectedName);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Program updated successfully";
    }

    $stmt->close();
}
$conn->close();
header("Location: ProgramInfoManagement.php");
?>