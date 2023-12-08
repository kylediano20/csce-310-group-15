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
    $DeleteName = $_POST["DeleteName"];

    if (isset($_POST["RemoveAccess"])) {
        $query = "UPDATE programs SET Access_Removed = 1 WHERE Name = '$DeleteName'";
        mysqli_query($conn, $query);
    } else {
        $sql = "SELECT Program_Num FROM programs WHERE Name = ?";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $DeleteName);
        $stmt->execute();

        $stmt->bind_result($ProgramDel);
        $stmt->fetch();
        $stmt->close();

        if ($ProgramDel !== null) {
            $query = "DELETE FROM events WHERE Program_Num = $ProgramDel";
            mysqli_query($conn, $query);

            $query = "DELETE FROM applications WHERE Program_Num = $ProgramDel";
            mysqli_query($conn, $query);

            $query = "DELETE FROM track WHERE Program_Num = $ProgramDel";
            mysqli_query($conn, $query);

            $query = "DELETE FROM cert_enrollment WHERE Program_Num = $ProgramDel";
            mysqli_query($conn, $query);

            $query = "DELETE FROM programs WHERE Program_Num = $ProgramDel";
            mysqli_query($conn, $query);
        }
    }

    $conn->close();
    header("Location: ProgramInfoManagement.php");
    exit();
}
?>
