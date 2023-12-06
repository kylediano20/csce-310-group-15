<?php
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
    if (isset($_POST["deleteDocumentID"])) {
        $docNum = intval($_POST["deleteDocumentID"]);

        $deleteDocumentQuery = "DELETE FROM documentation WHERE Doc_Num = ?";
        $stmtTracking = $conn->prepare($deleteDocumentQuery);

        if (!$stmtTracking) {
            die("Prepare failed: " . $conn->error);
        }

        $stmtTracking->bind_param("i", $docNum);

        if (!$stmtTracking->execute()) {
            die("Execute failed: " . $stmtTracking->error);
        }

        $stmtTracking->close();

        header("Location: StudentDocumentManagement.php");
        exit();
    }
}
$conn->close();
?>
