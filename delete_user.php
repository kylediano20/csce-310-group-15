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

    // Delete query
    $query = $conn->prepare("DELETE FROM Users WHERE UIN = ?");
    $query->bind_param("i", $uin);
    $query->execute();

    if ($query->affected_rows > 0) {
        echo "User successfully deleted.";
    } else {
        echo "No user found with UIN: $uin";
    }

    $query->close();
}

$conn->close();
?>
