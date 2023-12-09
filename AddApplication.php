<?php
// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "2001";
$dbname = "310_db";
// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $UIN = $_POST["UINin"];
    $ProgramNum = $_POST["ProgramNum"];
    $Purpose = $_POST["Purpose"];

    if (isset($_POST["UnComLabel"]) && isset($_POST["ComLabel"])) {
        $UnComDetails = $_POST["UnComDetails"];
        $ComCertDetails = $_POST["ComDetails"];

        $stmt = $conn->prepare("INSERT INTO Applications (Program_Num, UIN, Uncom_Cert, Com_Cert, Purpose_statement) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $ProgramNum, $UIN, $UnComDetails, $ComCertDetails, $Purpose);
        $stmt->execute();

    } elseif (isset($_POST["UnComLabel"])) {
        $UnComDetails = $_POST["UnComDetails"];

        $stmt = $conn->prepare("INSERT INTO Applications (Program_Num, UIN, Uncom_Cert, Purpose_statement) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $ProgramNum, $UIN, $UnComDetails, $Purpose);
        $stmt->execute();

    } elseif (isset($_POST["ComLabel"])) {
        $ComCertDetails = $_POST["ComDetails"];

        $stmt = $conn->prepare("INSERT INTO Applications (Program_Num, UIN, Com_Cert, Purpose_statement) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $ProgramNum, $UIN, $ComCertDetails, $Purpose);
        $stmt->execute();

    } else {
        $stmt = $conn->prepare("INSERT INTO Applications (Program_Num, UIN, Purpose_statement) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $ProgramNum, $UIN, $Purpose);
        $stmt->execute();

    }

    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Application Sent successfully";
    }
    $stmt->close();
}

$conn->close();
header("Location: ApplicationInformationManagement.php");
?>
