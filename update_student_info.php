<?php
session_start();


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

$uin = $_SESSION['uin'];

// Update Users table
$fields_users = [
    'First_Name' => 's',
    'M_Initial' => 's',
    'Last_Name' => 's',
    'Username' => 's',
    'Passwords' => 's',
    'User_Type' => 's',
    'Email' => 's',
    'Discord_Name' => 's'
];

foreach ($fields_users as $field => $type) {
    if (!empty($_POST[$field])) {
        $stmt = $conn->prepare("UPDATE Users SET $field = ? WHERE UIN = ?");
        $stmt->bind_param($type . "i", $_POST[$field], $uin);
        $stmt->execute();
        $stmt->close();
    }
}

// Update College_Student table
$fields_college_student = [
    'Gender' => 's',
    'Hispanic_Latino' => 'i', 
    'Race' => 's', 
    'US_Citizen' => 'i', 
    'First_Generation' => 'i', 
    'DoB' => 's', 
    'GPA' => 'd', 
    'Major' => 's', 
    'Minor_1' => 's', 
    'Minor_2' => 's', 
    'Expected_Graduation' => 'i', 
    'School' => 's', 
    'Current_Classification' => 's', 
    'Phone' => 'i', 
    'Student_Type' => 's'
];

foreach ($fields_college_student as $field => $type) {
    if (!empty($_POST[$field])) {
        $stmt = $conn->prepare("UPDATE College_Student SET $field = ? WHERE UIN = ?");
        $stmt->bind_param($type . "i", $_POST[$field], $uin);
        $stmt->execute();
        $stmt->close();
    }
}

echo "Information updated successfully";

$conn->close();
?>
