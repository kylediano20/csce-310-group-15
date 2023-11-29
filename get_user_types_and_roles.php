<?php
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

$query = "SELECT u.UIN, u.User_Type, s.Student_Type FROM Users u LEFT JOIN College_Student s ON u.UIN = s.UIN";
$result = $conn->query($query);

$userTypesAndRoles = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($userTypesAndRoles, $row);
    }
    echo json_encode($userTypesAndRoles);
} else {
    echo json_encode(['error' => 'No data found']);
}

$conn->close();
?>
