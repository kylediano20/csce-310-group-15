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
    $uin = $_POST['uin'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password']; // In a real application, hash this password
    $email = $_POST['email'];
    $discordName = $_POST['discordName'];

    // Insert into Users table
    $stmt = $conn->prepare("INSERT INTO Users (UIN, First_Name, Last_Name, Username, Passwords, User_Type, Email, Discord_Name) VALUES (?, ?, ?, ?, ?, 'admin', ?, ?)");
    $stmt->bind_param("issssss", $uin, $firstName, $lastName, $username, $password, $email, $discordName);
    $stmt->execute();

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "New administrator created successfully";
    }

    $stmt->close();
}

$conn->close();
?>
