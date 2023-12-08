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
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Information Management</title>
  <style>
    
    #UnComDetails {
      display: none;
    }

    #ComDetails {
      display: none;
    }

    #UnComDetailsEdit{
      display: none;
    }

    #ComDetailsEdit{
      display: none;
    }
  </style>
</head>
<body>

  <h1>Student Functionality</h1>
  <div class="ProgramApp"> 
    <h3>Program Application:</h2>
      <div class="InsertApplication">
        <form method="POST" action="AddApplication.php">
            <input type="text" id="UINin" name="UINin" placeholder="Enter UIN" required>
            <select name="ProgramNum" class="form-select" aria-label="Default select example">
                <option selected>Choose Program</option>
                <?php
                $table = "SELECT Program_Num, Name FROM programs;";
                $results = mysqli_query($conn, $table);

                while ($row = mysqli_fetch_assoc($results)) {
                    $programNum = $row['Program_Num'];
                    $programName = $row['Name'];
                    echo "<option value='$programNum'>$programName</option>";
                }
                ?>
            </select>
            <br>
            <label for="UnComLabel">Are you currently enrolled in
            other uncompleted certifications
            sponsored by the Cybersecurity
            Center? 
            </label>
            <input type="checkbox" id="UnCom_Cert" name="UnComLabel" onclick="toggleUncom()">
            <textarea id="UnComDetails" name="UnComDetails" rows="5" cols="50" placeholder="Enter Details"></textarea>
                
            <br>
            <label for="ComLabel">Have you completed any
            cybersecurity industry
            certifications via the
            Cybersecurity Center?
            </label>
            <input type="checkbox" id="Com_Cert" name="ComLabel" onclick="toggleCom()">
            <textarea id="ComDetails" name="ComDetails"rows="5" cols="50" placeholder="Enter Details"></textarea>
            <br>

            <textarea id="Purpose" name="Purpose" rows="10" cols="50" placeholder="Enter Purpose Statement" required></textarea>
            <br>
            <button type="submit" id="InsertApplication">Submit Application</button>
        </form>
      </div>
  </div>

  <div class="EditApp">
    <h3>Edit Application:</h3>
    <div class="EditApplication">
        <form method="POST" action="UpdateApplication.php">
            <input type="text" id="UINedit" name="UINedit" placeholder="Enter UIN">
            <input type="text" id="ProgramNumEdit"name="ProgramNumEdit" placeholder="Enter Program Number">
            <br>
            <label for="UnComLabelEdit">Are you currently enrolled in
                other uncompleted certifications
                sponsored by the Cybersecurity
                Center? 
            </label>
            <input type="checkbox" id="UnCom_CertEdit" name="UnComLabel" onclick="toggleUncomEdit()">
            <textarea id="UnComDetailsEdit" rows="5" cols="50" placeholder="Enter Details"></textarea>
                
            <br>
            <label for="ComLabel">Have you completed any
                cybersecurity industry
                certifications via the
                Cybersecurity Center?
            </label>
            <input type="checkbox" id="Com_CertEdit" name="ComLabel" onclick="toggleComEdit()">
            <textarea id="ComDetailsEdit" rows="5" cols="50" placeholder="Enter Details"></textarea>
            <br>

            <textarea id="PurposeEdit" name="PurposeEdit" rows="10" cols="50" placeholder="Enter Purpose Statement"></textarea>
            <br>
            <button type="submit" id="EditApplication">Update Application</button>
        </form>
    </div>
  </div>

  <div class="ReviewApp">
    <h3>Review Application:</h3>
    <div class="ReviewApplication">
      <input type="text" id="ReviewApp" placeholder="Enter Applicant UIN">
      <p>Application Number:</p>
      <p>Program Number:</p>
      <p>Uncompleted Certifications:</p>
      <p>Completed Certifications:</p>      
    </div>
  </div>
  <div class="RemoveProgress">
    <h3>Delete progress record:</h3>
    <div class="DeleteApplication">
        <form method="POST" action="DeleteApplication.php">
            <input type="text" id="AppDelete" name="AppDelete" placeholder="Enter Applicant UIN">
            <button type="submit" id="DeleteApplication" onclick="">Delete Application</button>
        </form>
    </div>
  </div>

  <script>
    function toggleUncom() {
      var checkbox = document.getElementById('UnCom_Cert');
      var textBox = document.getElementById('UnComDetails');
      textBox.style.display = checkbox.checked ? 'block' : 'none';
    }

    function toggleCom() {
      var checkbox = document.getElementById('Com_Cert');
      var textBox = document.getElementById('ComDetails');
      textBox.style.display = checkbox.checked ? 'block' : 'none';
    }

    function toggleUncomEdit() {
      var checkbox = document.getElementById('UnCom_CertEdit');
      var textBox = document.getElementById('UnComDetailsEdit');
      textBox.style.display = checkbox.checked ? 'block' : 'none';
    }

    function toggleComEdit() {
      var checkbox = document.getElementById('Com_CertEdit');
      var textBox = document.getElementById('ComDetailsEdit');
      textBox.style.display = checkbox.checked ? 'block' : 'none';
    }

  </script>
</body>
</html>
