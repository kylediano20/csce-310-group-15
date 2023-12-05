<!--This was coded by: Jaden Reyes-->
<?php
// Database connection details
$host = "localhost";
$dbUsername = "root";
$dbPassword = "jtsr101";
$dbname = "310_db";
$tablename = "documentation";
// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Get the maximum Document_ID from the database
$result = $conn->query("SELECT MAX(Doc_Num) AS maxDocNum FROM documentation");
$row = $result->fetch_assoc();
$nextDocID = $row['maxDocNum'] + 1;
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin and Student Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Cybersecurity Center Student Tracking and Reporting Tool</h1>
    </header>

    <!-- Document Management Functionalities -->
    <div class="container" class="functionality">
        <div id=student>
            <h2>Student Document Management</h2>
            <!-- Insert Document Form -->
            <div>
                <h3>Upload a Document</h3>
                <form id="uploadDocumentForm" action = uploadDocument.php method = "POST">
                    <p>
                        <strong>Application Number:</strong>
                        <input type="text" id="applicationNumber" name="applicationNumber" required>
                    </p>
                    <p>
                        <strong>Document Type:</strong>
                        <input type="text" id="documentType" name="documentType" required>
                    </p>
                    <p>
                        <strong>Document Link:</strong>
                        <input type="text" id="documentLink" name="documentLink" required>

                    <p>
                    <button type="button" onclick = "documentUploadAlert()">Upload Document</button>
                </form>

                <!-- Display Document ID -->
                <div id="documentIdDisplay" style="display: none;">
                    <p>
                        <strong>Document ID:</strong>
                        <span id="displayDocumentID"><?php echo $nextDocID; ?></span>
                    </p>
                    <p>
                        Document uploaded! Please refresh the page to add another.
                    </p>
                </div>
            </div>

            <hr style = "margin-top: 25px;">

            <!-- Update Documents -->
            <div>
                <h3>Replace a Document</h3>
                <form id="updateDocumentForm">
                    <p>
                        <strong>Enter Document ID:</strong>
                    </p>
                    <input type="text" id="updateDocumentID" name="updateDocumentID" required>
                    <button type="button" onclick="editDocumentDetails()">Continue</button>
                </form>
                <div id="updateDocumentDetails" style="display:none;">
                    <p>
                        <strong>Document Type: </strong>
                        <input type="text" id="updateDocType" name="updateDocType" placeholder="Document Type">
                    </p>
                    <p>
                        <strong>Document Link: </strong>
                        <input type="text" id="updateDocLink" name="updateDocLink" placeholder="Document Link">
                    </p>
                    <button type="submit" onclick="handleUpdateDocumentDetails()">Update Document</button>
                </div>
            </div>


            <hr style = "margin-top: 25px;">

            <!-- Select Document -->
            <div>
                <h3>View Uploaded Documents</h3>
                <!-- Form to enter Document ID for viewing -->
                <form id="viewDocumentsForm" action = "viewDocuments.php" method = "POST">
                    <label for="viewDocumentUIN">Enter your UIN:</label>
                    <input type="text" id="viewDocumentUIN" name="viewDocumentUIN" required>
                    <button type="submit">View Documents</button>
                    <p></p>
                </form>
                <!-- Display Uploaded Documents -->
                <div id="documentList">
                    
                    <!-- Document list will be displayed here -->
                </div>
            </div>

            <hr style = "margin-top: 25px;">

            <!-- Delete Document -->
            <div>
                <h3>Remove a Document</h3>
                <form id="deleteDocumentForm" action = "deleteDocument.php" method = "POST">
                    <label for="deleteDocumentID">Enter Document ID:</label>
                    <input type="text" id="deleteDocumentID" name="deleteDocumentID" required>
                    <button type="submit" onclick="deleteDocAlert()">Delete Document</button>
                </form>
            </div>

        </div>
    </div>
    <script>
         function deleteDocAlert() {
            alert("Document Deleted!"); 
        }
        function documentUploadAlert() {
            // Display Document ID
            document.getElementById('documentIdDisplay').style.display = 'block';

            // Get form data
            var formData = new FormData(document.getElementById('uploadDocumentForm'));

            // Send form data asynchronously using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'uploadDocument.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Successfully uploaded, display Document ID
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('displayDocumentID').innerText = response.documentId;
                } else {
                    // Handle error
                    console.error('Error uploading document');
                }
            };
            xhr.send(formData);

            // Prevent the form from submitting immediately
            return false;
        }
        // Functions for edit events
        function editDocumentDetails() {
            document.getElementById('updateDocumentDetails').style.display = 'block';
        }
        function handleUpdateDocumentDetails() {
            var docLink = document.getElementById('updateDocLink').value;
            var docType = document.getElementById('updateDocType').value;
            var documentID = document.getElementById('updateDocumentID').value;

            fetch("replaceDocument.php", {
                method: "POST",
                body: new URLSearchParams({
                    updateDocLink: docLink,
                    updateDocType: docType,
                    updateDocumentID: documentID,
                }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.error) {
                    alert("Error updating document details: " + result.error);
                } else {
                    alert("Document Updated!");
                    // Clear the input fields
                    document.getElementById('updateDocType').value = '';
                    document.getElementById('updateDocLink').value = '';
                    document.getElementById('updateDocumentDetails').style.display = 'none';
                    document.getElementById('updateDocumentID').value = '';
                }
            })
        }
        // Function to handle form submission and view documents
        function viewDocuments() {
            event.preventDefault();

            var viewDocumentUIN = document.getElementById('viewDocumentUIN').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'viewDocuments.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {

                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        alert('Error: ' + response.error);
                    } else if (response.documents) {
                        response.documents.sort(function (a, b) {
                        return a.Doc_Num - b.Doc_Num;
                        });

                        // Populate the documentList div with the document information
                        var documentListDiv = document.getElementById('documentList');
                        documentListDiv.innerHTML = "";

                        response.documents.forEach(function (document) {
                            var documentInfo = "Document Number: " + document.Doc_Num + "<br>" +
                                            "Application Number: " + document.App_Num + "<br>" +
                                            "Document Type: " + document.Doc_Type + "<br>" +
                                            "Document Link: " + document.Link + "<br><br>";
                            documentListDiv.innerHTML += documentInfo;
                        });
                    } else {

                        alert('Message: ' + response.message);
                    }
                }
            };
            xhr.send('viewDocumentUIN=' + encodeURIComponent(viewDocumentUIN));
        }
        document.getElementById('viewDocumentsForm').addEventListener('submit', viewDocuments);
    </script>
</body>
</html>