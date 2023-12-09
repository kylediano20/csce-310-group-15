<?php
// file coded by Kyle Diano
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

    // Update query to deactivate the user
    $query = $conn->prepare("UPDATE Users SET User_Type = 'inactive' WHERE UIN = ?");
    $query->bind_param("i", $uin);
    $query->execute();

    if ($query->affected_rows > 0) {
        echo "User successfully deactivated.";
    } else {
        echo "No user found with UIN: $uin";
    }

    $query->close();
}

$conn->close();
?>
