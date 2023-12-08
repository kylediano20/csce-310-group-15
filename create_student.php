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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uin = $_POST['uin'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userType = 'college_student';
    $email = $_POST['email'];

    // Insert into Users table
    $stmt = $conn->prepare("INSERT INTO Users (UIN, First_Name, Last_Name, Username, Password, User_Type, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $uin, $firstName, $lastName, $username, $password, $userType, $email);
    $stmt->execute();

    // Insert into College_Student table
    $stmt = $conn->prepare("INSERT INTO College_Student (UIN) VALUES (?)");
    $stmt->bind_param("i", $uin);
    $stmt->execute();

    $stmt->close();
    echo "New student created successfully";
}

$conn->close();
?>
