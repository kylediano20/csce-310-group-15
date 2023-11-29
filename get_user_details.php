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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uin = $_POST['uin'];

    // Query to fetch user details and, if applicable, college student details based on UIN
    $query = $conn->prepare("SELECT U.*, CS.* FROM Users U
                             LEFT JOIN College_Student CS ON U.UIN = CS.UIN
                             WHERE U.UIN = ?");
    $query->bind_param("i", $uin);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Manually set UIN in $user array
        $user['UIN'] = $uin;

        // Return all user details, including college student details (if available)
        echo json_encode($user);
    } else {
        // If no user is found with that UIN
        echo json_encode(['error' => 'User not found']);
    }

    $query->close();
}

$conn->close();
?>
