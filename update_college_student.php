<?php
// Assuming a POST request with form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sys";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $uin = $conn->real_escape_string($_POST['uin']);

    // Update Users table
    $userFields = ['First_Name', 'M_Initial', 'Last_Name', 'Username', 'Passwords', 'User_Type', 'Email', 'Discord_Name'];
    foreach ($userFields as $field) {
        if (!empty($_POST[$field])) {
            $value = $conn->real_escape_string($_POST[$field]);
            $sql = "UPDATE Users SET $field = '$value' WHERE UIN = $uin";
            if (!$conn->query($sql)) {
                // Handle error
                echo "Error updating Users record: " . $conn->error;
            }
        }
    }

    // Update College_Student table
    $studentFields = ['Gender', 'Hispanic_Latino', 'Race', 'US_Citizen', 'First_Generation', 'DoB', 'GPA', 'Major', 'Minor_1', 'Minor_2', 'Expected_Graduation', 'School', 'Current_Classification', 'Phone', 'Student_Type'];
    foreach ($studentFields as $field) {
        if (!empty($_POST[$field])) {
            $value = $conn->real_escape_string($_POST[$field]);
            $sql = "UPDATE College_Student SET $field = '$value' WHERE UIN = $uin";
            if (!$conn->query($sql)) {
                // Handle error
                echo "Error updating College_Student record: " . $conn->error;
            }
        }
    }

    // Close connection
    $conn->close();

    // Success message
    echo "College student details updated successfully.";
}
?>
