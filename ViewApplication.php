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
    $ReviewApplicationUIN = $_POST['ReviewApp'];

    // Select documents based on UIN - used view here
    $stmt = $conn->prepare("SELECT Program_Num, Uncom_Cert, Com_Cert, Purpose_Statement FROM Applications WHERE UIN = ?");
    $stmt->bind_param("i", $ReviewApplicationUIN);
    $stmt->execute();

    if ($stmt->error) {
        echo json_encode(["error" => "Query execution error: " . $stmt->error]);
    } else {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $documents = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(["documents" => $documents], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["message" => "No documents found for the given UIN"]);
        }
    }

    $stmt->close();
    
    // Note: Remove the redirect code here
    exit();
}

$conn->close();
?>
