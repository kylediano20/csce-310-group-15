<?php
// This was coded by Jaden Reyes
// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "jtsr101";
$dbname = "310_db";

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $viewDocumentUIN = $_POST['viewDocumentUIN'];

    // Select documents based on UIN
    $stmt = $conn->prepare("
        SELECT D.Doc_Num, D.App_Num, D.Doc_Type, D.Link 
        FROM college_student AS CS 
        JOIN applications AS A ON CS.UIN = A.UIN 
        JOIN documentation AS D ON A.App_Num = D.App_Num 
        WHERE CS.UIN = ?
    ");
    $stmt->bind_param("i", $viewDocumentUIN);
    $stmt->execute();

    if ($stmt->error) {
        echo json_encode(["error" => "Query execution error: " . $stmt->error]);
    } else {
        // Fetch the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
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
