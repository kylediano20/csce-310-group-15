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

    $reportName = $_POST["ProgramReportName"];

    $query = "SELECT users.UIN, users.First_Name, users.M_Initial, users.Last_Name,
                applications.Uncom_Cert, applications.Com_Cert, applications.Purpose_Statement
                FROM users
                JOIN college_student ON users.UIN = college_student.UIN
                JOIN applications ON college_student.UIN = applications.UIN
                JOIN programs ON applications.Program_Num = programs.Program_Num
                WHERE programs.name = '$reportName';";

    $Results = mysqli_query($conn, $query);

    $tableClass = 'table table-striped';
    $tableScope = '"col"';
    $tableScopeRow = '"row"';

    echo "<h2 class='h2 mt-2'> Program: {$reportName}</h2>";
    echo "<table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Name</th>
                <th scope='col'>Uncommon Certifications</th>
                <th scope='col'>Common Certifications</th>
                <th scope='col'>Purpose Statement</th>
            </tr>
        </thead>
        <tbody>";

    while ($Rows = mysqli_fetch_assoc($Results)) {
        echo "
                <tr>
                    <th scope='row'>{$Rows['UIN']}</th>
                    <td>{$Rows['First_Name']} {$Rows['M_Initial']} {$Rows['Last_Name']}</td>
                    <td>{$Rows['Uncom_Cert']}</td>
                    <td>{$Rows['Com_Cert']}</td>
                    <td>{$Rows['Purpose_Statement']}</td>
                </tr>";
    }

    echo "</tbody>
    </table>";

}

$conn->close();
header("Location: ProgramInfoManagement.php");
exit();

?>