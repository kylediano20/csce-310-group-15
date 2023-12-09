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
    $viewDocumentUIN = $_POST['viewDocumentUIN'];

    // Select documents based on UIN - used view here
    $stmt = $conn->prepare("
        SELECT * FROM student_doc_v WHERE UIN = ?"
    );
    $stmt->bind_param("i", $viewDocumentUIN);
    $stmt->execute();

    if ($stmt->error) {
        echo json_encode(["error" => "Query execution error: " . $stmt->error]);
    } else {
        // Fetch the result
        $result = $stmt->get_result();

        // Check if there are documents
        if ($result->num_rows > 0) {
            // Output the document information in JSON format
            $documents = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(["documents" => $documents]);
        } else {
            echo json_encode(["message" => "No documents found for the given UIN"]);
        }
    }

    $stmt->close();
}

$conn->close();
?>
