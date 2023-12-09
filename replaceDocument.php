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
    $updateDocLink = $_POST['updateDocLink'];
    $updateDocType = $_POST['updateDocType'];
    $updateDocumentID = $_POST['updateDocumentID'];

    // update documents table
    $stmt = $conn->prepare("UPDATE documentation SET Link = ?, Doc_Type = ? WHERE Doc_Num = ?");
    $stmt->bind_param("ssi", $updateDocLink, $updateDocType, $updateDocumentID);
    $stmt->execute();

    if ($stmt->error) {
        echo json_encode(["error" => $stmt->error]); 
    } else {
        echo json_encode(["message" => "Document updated"]);
    }

    $stmt->close();
}
$conn->close();
?>