<!--This was coded by: Jaden Reyes-->
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
// Get the maximum Event_ID from the database
$result = $conn->query("SELECT MAX(Event_ID) AS maxEventID FROM events");
$row = $result->fetch_assoc();
$nextEventID = $row['maxEventID'] + 1;
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
    <nav id="dashboardPage" style="display: none;">
        <a href="#" onclick="showSection('admin')">Admin Dashboard</a>
        <a href="#" onclick="showSection('student')">Student Dashboard</a>
    </nav>
    
    <!-- Event Admin Functionalities -->
    <div class="container" class="functionality">
        <div id="admin">
            <h2 style="text-align: center;">Event Functionalities</h2>
            <!-- Create Event Form -->
            <div>
                <h3 style="color: maroon;">Create a New Event</h3>
                <form id="createEventForm" action="createEvent.php" method="POST">
                    <p>
                        <strong>Event ID:</strong>
                        <span id="eventIDNumber"><?php echo $nextEventID; ?></span>
                    </p>
                    <p>
                        <strong>UIN:</strong>
                        <input type="number" id="uin" name="uin" required>
                    </p>
                    <p>
                        <strong>Program Number:</strong> 
                        <input type="number" id="programNum" name="programNum" required>
                    </p>
                    <p>
                        <strong>Start Date:</strong>
                        <input type="date" id="startDate" name="startDate" required>
                    </p>
                    <p>
                        <strong>Time:</strong>
                        <input type="time" id="time" name="time" required>
                    </p>
                    <p>
                        <strong>Location:</strong>
                        <input type="text" id="location" name="location" required>
                    </p>
                    <p>
                        <strong>End Date:</strong>
                        <input type="date" id="endDate" name="endDate" required>
                    </p>
                    <p>
                        <strong>Event Type:</strong>
                        <input type="text" id="eventType" name="eventType" required>
                    </p>
                    <div>
                        <button type="submit" onclick="createEventAlert()">Create Event</button>
                    </div>
                </form>
            </div>

            <hr style = "margin-top: 25px;">

             <!-- Edit Event Details Form -->
             <div>
                <h3>Update Event Details</h3>
                <form id="editEventForm">     
                    <label for="editEventID">Enter Event ID:</label>
                    <input type="text" id="editEventID" name="editEventID" required>
                    <button type="button" onclick="handleEditAccessButton()">Continue</button>
                </form>
                <div id="editEventDetails" style="display: none;">
                    <p>
                        <strong>Start Date:</strong>
                        <input type="date" id="updateStartDate" name="updateStartDate" placeholder="Start Date">
                    </p>
                    <p>
                        <strong>Time:</strong>
                        <input type="time" id="updateTime" name="updateTime" placeholder="Time">
                    </p>
                        <strong>Location:</strong>
                        <input type="text" id="updateLocation" name="updateLocation" placeholder="Location">
                    </p>
                    <p>
                        <strong>End Date:</strong>
                        <input type="date" id="updateEndDate" name="updateEndDate" placeholder="End Date">
                    </p>
                    <p>
                        <strong>Event Type:</strong>
                        <input type="text" id="updateEventType" name="updateEventType" placeholder="Event Type">
                    </p>
                    <button type="submit" onclick="handleUpdateEventDetails()">Update Event Details</button>
                </div>
            </div>

            <hr style = "margin-top: 25px;">

            <!--Attendance Updates-->
            <div>
                <h3>Update Attendance Details</h3>
                <!--List all of the attendees (UIN, First & Last Name)-->
                <div>
                    <h4>View Attendees</h4>
                    <form id="viewEventAttendees" action = "retrieveAttendees.php" method = "POST">
                        <label for="viewEventAttendeesID">Enter Event ID:</label>
                        <input type="text" id="viewEventAttendeesID" name="viewEventAttendeesID" required>
                        <button type="submit">View Attendees</button>
                    </form>
                    <div id="attendeesList">
                        <!-- attendees list will be displayed here -->
                    </div>
                </div>
                <!--Add Attendees-->
                <div>
                    <h4>Add Attendees</h4>
                    <form id="addEventAtendees" action = "addAttendee.php" method = "POST">
                        <label for="addEventAttendeeID">Enter Event ID:</label>
                        <input type="text" id="addEventAttendeeID" name="addEventAttendeeID" required>
                        <label for="addEventUIN">Enter UIN:</label>
                        <input type="text" id="addEventUIN" name="addEventUIN" required>
                        <button type="submit" onclick = "addAttendeeEvent()">Add Attendee</button>
                    </form>
                </div>
                <!--Delete Attendees-->
                <div>
                    <h4>Remove Attendees</h4>
                    <form id="removeEventAtendees" action = "removeAttendee.php" method = "POST">
                        <label for="removeEventAttendeeID">Enter Event ID:</label>
                        <input type="text" id="removeEventAttendeeID" name="removeEventAttendeeID" required>
                        <label for="removeEventUIN">Enter UIN:</label>
                        <input type="text" id="removeEventUIN" name="removeEventUIN" required>
                        <button type="submit" onclick = "removeAttendeeEvent()">Remove Attendee</button>
                    </form>
                </div>
            </div>

            <hr style = "margin-top: 25px;">

            <!-- Access Event Information -->
            <div>
                <h3 style="color: maroon;">Access Event Information</h3>
                <!-- Form to enter Event ID -->
                <form id="accessEventForm">
                    <label for="accessEventID">Enter Event ID:</label>
                    <input type="text" id="accessEventID" name="accessEventID" required>
                    <button type="button" onclick="handleAccessEvent()">Access Event</button>
                </form>
                <!-- Display Event Information, should only show up after Access Event is entered -->
                <div id="eventDetails" style="display: none;">
                    <p><strong>Event ID:</strong> <span id="eventID"></span></p>
                    <p><strong>UIN:</strong> <span id="eventUIN"></span></p>
                    <p><strong>Program Number:</strong> <span id="eventProgramNum"></span></p>
                    <p><strong>Start Date:</strong> <span id="eventStartDate"></span></p>
                    <p><strong>Time:</strong> <span id="eventTime"></span></p>
                    <p><strong>Location:</strong> <span id="eventLocation"></span></p>
                    <p><strong>End Date:</strong> <span id="eventEndDate"></span></p>
                    <p><strong>Event Type:</strong> <span id="eventEventType"></span></p>
                </div>
            </div>

            <hr style = "margin-top: 25px;">

            <!-- Delete Event -->
            <div>
                <h3 style="color: maroon;">Delete an Event</h3>
                <form id="deleteEventForm" method="post" action="deleteEvent.php">
                    <label for="deleteEventID">Enter Event ID:</label>
                    <input type="text" id="deleteEventID" name="deleteEventID" required>
                    <button type="submit" onclick="deleteEventAlert()">Delete Event</button>
                </form>
            </div>

        </div>
    </div>
    <script>
        /* functions for the alerts */
        function createEventAlert() {
            alert("Event Created!"); 
        }
        function deleteEventAlert() {
            alert("Event Deleted!"); 
        }
        function addAttendeeEvent(){
            alert("Attendee Added!")
        }
        function removeAttendeeEvent(){
            alert("Attendee Removed!")
        }
         /* Function to access the Event information and autopopulate the form */
        function handleEditAccessButton() {
            var eventID = document.getElementById("editEventID").value;

            // Fetch existing data based on the provided Event ID
            fetch("accessEvent.php", {
                method: "POST",
                body: new URLSearchParams({ accessEventID: eventID }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then(response => response.json())
            .then(data => {
                // Check if the response contains an error message
                if (data.error) {
                    console.error("Error fetching event details:", data.error);
                } else {
                    // Populate the form fields with existing data
                    document.getElementById('updateStartDate').value = data.Start_Date;
                    document.getElementById('updateTime').value = data.Time;
                    document.getElementById('updateLocation').value = data.Location;
                    document.getElementById('updateEndDate').value = data.End_Date;
                    document.getElementById('updateEventType').value = data.Event_Type;

                    // Show the event details div
                    document.getElementById('editEventDetails').style.display = 'block';
                }
            })
            .catch(error => {
                console.error("Error fetching event details:", error);
            });
        }
        /* Function to update the Event details in the database */
        function handleUpdateEventDetails() {
            var eventID = document.getElementById('editEventID').value;
            var startDate = document.getElementById('updateStartDate').value;
            var time = document.getElementById('updateTime').value;
            var location = document.getElementById('updateLocation').value;
            var endDate = document.getElementById('updateEndDate').value;
            var eventType = document.getElementById('updateEventType').value;

            // Update the database with new values
            fetch("editEvent.php", {
                method: "POST",
                body: new URLSearchParams({
                    editEventID: eventID,
                    updateStartDate: startDate,
                    updateTime: time,
                    updateLocation: location,
                    updateEndDate: endDate,
                    updateEventType: eventType,
                }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);
                alert("Event Updated!");
                document.getElementById('editEventDetails').style.display = 'none';
                document.getElementById('editEventID').value = '';
            })
            .catch(error => {
                console.error("Error updating event details:", error);
            });
        }
        /* Function to access the Event information */
        function handleAccessEvent() {
            var eventID = document.getElementById("accessEventID").value;
            fetch("accessEvent.php", {
                method: "POST",
                body: new URLSearchParams({ accessEventID: eventID }),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('eventID').innerText = data.Event_ID;
                document.getElementById('eventUIN').innerText = data.UIN;
                document.getElementById('eventProgramNum').innerText = data.Program_Num;
                document.getElementById('eventStartDate').innerText = data.Start_Date;
                document.getElementById('eventTime').innerText = data.Time;
                document.getElementById('eventLocation').innerText = data.Location;
                document.getElementById('eventEndDate').innerText = data.End_Date;
                document.getElementById('eventEventType').innerText = data.Event_Type;
                // Show the event details div
                document.getElementById('eventDetails').style.display = 'block';
            })
            .catch(error => {
                console.error("Error fetching event details:", error);
            });
        }
        /* function to view Attendees */
        function viewAttendees(event) {
            event.preventDefault();

            var viewEventAttendeesID = document.getElementById('viewEventAttendeesID').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'retrieveAttendees.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        alert('Error: ' + response.error);
                    } else if (response.documents) {
                        response.documents.sort(function (a, b) {
                            return a.UIN - b.UIN;
                        });

                        // Populate the attendeesList div with the attendee information
                        var attendeesListDiv = document.getElementById('attendeesList');
                        attendeesListDiv.innerHTML = "";

                        response.documents.forEach(function (attendee) {
                            var attendeeInfo = "UIN: " + attendee.UIN + "<br>" +
                                "First Name: " + attendee.First_Name + "<br>" +
                                "Last Name: " + attendee.Last_Name + "<br>";
                            attendeesListDiv.innerHTML += attendeeInfo;
                        });
                    } else {
                        alert('Message: ' + response.message);
                    }
                }
            };
            xhr.send('viewEventAttendeesID=' + encodeURIComponent(viewEventAttendeesID));
        }
        document.getElementById('viewEventAttendees').addEventListener('submit', viewAttendees);
    </script>


    <br><br>
    <a href="admin_test.html"> Back to functionalities</a> 
    <br><br>
    <!-- Add a logout button or link -->
    <a href="logout.php">Log Out</a>
</body>
</html>