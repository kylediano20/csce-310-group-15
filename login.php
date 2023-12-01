<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND passwords = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($row['User_Type'] == 'inactive') {
            // Redirect or inform the user they are inactive
            header("Location: index.html?status=inactive");
            exit;
        }

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['User_Type'];
        $_SESSION['uin'] = $row['UIN'];

        if ($_SESSION['role'] == 'admin') {
            header("Location: admin.html");
        } else {
            header("Location: student.html");
        }
        exit;
    } else {
        echo "Invalid username or password.<br>";
    }
}

$conn->close();
?>
