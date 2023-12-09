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
$uin = $_POST['uin'];
$class_id = $_POST['class_id'];
$status = $_POST['status'];
$semester = $_POST['semester'];
$year = $_POST['year'];

$sql = "INSERT INTO class_enrollment (UIN, Class_ID, Status, Semester, Year) VALUES ('$uin', '$class_id', '$status', '$semester', '$year')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
