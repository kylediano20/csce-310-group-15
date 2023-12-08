<?php
session_start();
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

// Check if the session variable for UIN is set
if (isset($_SESSION['uin'])) {
    $uin = $_SESSION['uin'];

    // Fetch class enrollments
    echo "<h2>Class Enrollments:</h2>";
    $class_sql = "SELECT * FROM class_enrollment WHERE UIN=?";
    $class_stmt = $conn->prepare($class_sql);
    $class_stmt->bind_param("i", $uin);
    $class_stmt->execute();
    $class_result = $class_stmt->get_result();

    if ($class_result->num_rows > 0) {
        while($row = $class_result->fetch_assoc()) {
            echo "ID: " . $row["CE_NUM"]. " - Status: " . $row["Status"]. " - Semester: " . $row["Semester"]. " - Year: " . $row["Year"]. "<br>";
        }
    } else {
        echo "No class enrollment records found.<br>";
    }

    // Fetch internship applications
    echo "<h2>Internship Applications:</h2>";
    $intern_sql = "SELECT * FROM intern_app WHERE UIN=?";
    $intern_stmt = $conn->prepare($intern_sql);
    $intern_stmt->bind_param("i", $uin);
    $intern_stmt->execute();
    $intern_result = $intern_stmt->get_result();

    if ($intern_result->num_rows > 0) {
        while($row = $intern_result->fetch_assoc()) {
            echo "ID: " . $row["IA_Num"]. " - Status: " . $row["Status"]. " - Year: " . $row["Year"]. "<br>";
        }
    } else {
        echo "No internship application records found.<br>";
    }

    // Fetch certification enrollments
    echo "<h2>Certification Enrollments:</h2>";
    $cert_sql = "SELECT * FROM cert_enrollment WHERE UIN=?";
    $cert_stmt = $conn->prepare($cert_sql);
    $cert_stmt->bind_param("i", $uin);
    $cert_stmt->execute();
    $cert_result = $cert_stmt->get_result();

    if ($cert_result->num_rows > 0) {
        while($row = $cert_result->fetch_assoc()) {
            echo "ID: " . $row["CertE_Num"]. " - Status: " . $row["Status"]. " - Training Status: " . $row["Training_Status"]. "<br>";
        }
    } else {
        echo "No certification enrollment records found.<br>";
    }

    $class_stmt->close();
    $intern_stmt->close();
    $cert_stmt->close();
} else {
    echo "Student is not logged in.";
}

$conn->close();
?>
