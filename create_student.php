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
    $password = $_POST['password'];
    $userType = 'college_student';
    $email = $_POST['email'];

    // Insert into Users table with a try-catch block to handle the unique constraint violation
    try {
        $insert_stmt = $conn->prepare("INSERT INTO Users (UIN, First_Name, Last_Name, Username, Passwords, User_Type, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert_stmt->bind_param("issssss", $uin, $firstName, $lastName, $username, $password, $userType, $email);
        
        if ($insert_stmt->execute()) {
            // Insert into College_Student table
            $insert_college_stmt = $conn->prepare("INSERT INTO College_Student (UIN) VALUES (?)");
            $insert_college_stmt->bind_param("i", $uin);
            
            if ($insert_college_stmt->execute()) {
                echo "New student created successfully";
            } else {
                echo "Error: Failed to create a student.";
            }
            
            $insert_college_stmt->close();
        } else {
            echo "Error: Failed to create a student.";
        }
        
        $insert_stmt->close();
    } catch (Exception $e) {
        echo "Error: Username already exists. Please choose a different username.";
    }
}

$conn->close();
?>
