<?php
// Assuming a POST request with form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $uin = $conn->real_escape_string($_POST['uin']);

    // Prepare SQL statements for Users table
    $fields = ['First_Name', 'M_Initial', 'Last_Name', 'Username', 'Passwords', 'User_Type', 'Email', 'Discord_Name'];
    foreach ($fields as $field) {
        echo "here $field";
        if (!empty($_POST[$field])) {
            $value = $conn->real_escape_string($_POST[$field]);
            echo "here";
            $sql = "UPDATE Users SET $field = '$value' WHERE UIN = $uin";
            if (!$conn->query($sql)) {
                // Handle error
                echo "Error updating record: " . $conn->error;
            }
        }
    }
    echo "uin $uin";
    // Close connection
    $conn->close();

    // Success message
    echo "User details updated successfully.";
}
?>
