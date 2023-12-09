<!-- Created by: Emil Agbigay-->
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

    // Output the HTML content instead of redirecting
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
    
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Info Management</title>
</head>

<body>
    <h1>Admin Functionality</h1>
    <div class="Program">
        <h3>Add New Program:</h3>
        <div class="ProgramEnter">
            <form id= "AddProgramForm" method="POST" action="AddProgram.php">
                <input type="text" name="ProgramName" id="ProgramName" placeholder="Enter Program Name" required>
                <br>
                <textarea name="ProgramDesc" type="text" id="ProgramDesc" rows="5" cols="50" placeholder="Enter Program Description" required></textarea>
                <br>
                <button type="submit" id="InsertProgram">Create Program</button>
            </form>
        </div>
    </div>

    <div class="update">
        <h3>Update Program:</h3>
        <div class="ProgramUpdate">
            <form id="UpdateProgramForm" method="POST" action="UpdateProgram.php">
                <select name="ProgramNameUpdate" class="form-select" aria-label="Default select example">
                    <option selected>Choose Program</option>
                    <?php
                    $table = "SELECT Name FROM programs;";
                    $results = mysqli_query($conn, $table);

                    while ($Rows = mysqli_fetch_assoc($results)) {
                        $programName = $Rows['Name'];
                        echo "<option value='$programName'>$programName</option>";
                    }
                    ?>
                </select>
                <br>
                <input type="text" id="NewProgramName" name="NewProgramName" placeholder="New Program Name">
                <br>
                <textarea name="NewProgramDesc" id="NewProgramDesc" rows="5" cols="50" placeholder="New Program Description"></textarea>
                <br>
                <button type="submit" id="UpdateProgram">Update</button>
            </form>
        </div>
    </div>


    <div class="Report">
        <h3>Create Program Report:</h3>
        <div class="CreateReport">
            <form method="POST" id="reportForm">
                <select name="ProgramReportName" class="form-select" aria-label="Default select example">
                    <option selected>Choose Program</option>
                    <?php
                    $table = "SELECT Name FROM programs;";
                    $results = mysqli_query($conn, $table);

                    while ($Rows = mysqli_fetch_assoc($results)) {
                        $programName = $Rows['Name'];
                        echo "<option value='$programName'>$programName</option>";
                    }
                    ?>
                </select>
                <button type="submit" id="SubmitReport">Get Program Report</button>
                <br>
                <div class="OutputReport">
                    
                </div>
            </form>
        </div>
    </div>

    <div class="delete">
        <h3>Delete Program:</h3>
        <form method="POST" action="DeleteProgram.php">
            <select name="DeleteName" class="form-select" aria-label="Default select example">
                <option selected>Choose Program</option>
                <?php
                $table = "SELECT Name FROM programs;";
                $results = mysqli_query($conn, $table);

                while ($Rows = mysqli_fetch_assoc($results)) {
                    $programName = $Rows['Name'];
                    echo "<option value='$programName'>$programName</option>";
                }
                ?>
            </select>
            <label for="RemoveAccessCheck">Only Delete Access:</label>
            <input type="checkbox" id="RemoveAccessCheck" name="RemoveAccess">
            <br>
            <button type="submit" id="DeleteButton" >Delete</button>
        </form>
    </div>

    <script>
        document.getElementById('reportForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            var form = event.target;
            var formData = new FormData(form);

            fetch(form.action, {
                method: form.method,
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                document.querySelector(".OutputReport").innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>

</body>


</html>