<?php
// file coded by Kyle Diano
session_start();

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

$response = []; // Initialize an array to hold the response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'college_student') {
        // Use UIN from session for college students
        $uin = $_SESSION['uin'];
    } else {
        // Use UIN from POST data for other roles
        $uin = $_POST['uin'] ?? 'UIN not set in POST';
    }

    // Adding debug information to the response
    $response['debug'] = "UIN being queried: " . $uin;

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

        // Add the user data to the response
        $response['user'] = $user;
    } else {
        // If no user is found with that UIN
        $response['error'] = 'User not found';
    }

    $query->close();
}

$conn->close();

// Encode the entire response as JSON
echo json_encode($response);
?>
