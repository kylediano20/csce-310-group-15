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
    $UIN = $_POST["UINedit"];
    $ProgramNum = $_POST["ProgramNumEdit"];
    $Purpose = $_POST["PurposeEdit"];

    // Checkboxes
    $hasUnComLabel = isset($_POST["UnComLabel"]);
    $hasComLabel = isset($_POST["ComLabel"]);

    // Additional details based on checkboxes
    $UnComDetails = $hasUnComLabel ? $_POST["UnComDetailsEdit"] : null;
    $ComCertDetails = $hasComLabel ? $_POST["ComDetailsEdit"] : null;

    // Prepare the SQL statement for UPDATE
    $sql = "UPDATE Applications SET ";
    $types = "";
    $bindParams = array();

    // Dynamically build the SET clause and bind parameters
    if ($hasUnComLabel) {
        $sql .= "Uncom_Cert = ?, ";
        $types .= "s";
        $bindParams[] = $UnComDetails;
    }
    if ($hasComLabel) {
        $sql .= "Com_Cert = ?, ";
        $types .= "s";
        $bindParams[] = $ComCertDetails;
    }

    // Add common elements
    $sql .= "Purpose_statement = ? WHERE UIN = ? AND Program_Num = ?";
    $types .= "sii";
    $bindParams[] = $Purpose;
    $bindParams[] = $UIN;
    $bindParams[] = $ProgramNum;

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$bindParams);

    // Execute the statement
    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "Application Updated successfully";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
header("Location: ApplicationInformationManagement.php");
?>
