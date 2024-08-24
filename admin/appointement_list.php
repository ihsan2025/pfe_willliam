<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calendar Icon</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
</head>

<body style="padding-top: 50px;">

    <div class="container">
        <div class="d-flex w-50 mx-auto">
            <input id="searchEmail" class="form-control" placeholder="Search by email">
            <button id="searchBtn" class="btn btn-primary">Search</button>
        </div>
        <div class="row">
            <div class="col-md-8" style="margin-top: 3%;">
                <div class="tab-content" id="nav-tabContent" style="width: 950px;">
                    <div id="list-app" role="tabpanel" aria-labelledby="list-home-list">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Patient</th>
                                    <th scope="col">Appointment Date</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Doctor</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="appointmentTableBody">
                                <!-- Filtered appointments will be inserted here -->
                            </tbody>
                        </table>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Appointment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="process_appointment.php" method="POST">
                        <input type="hidden" id="appointment_id" name="appointment_id">

                        <label for="doctor_id">Doctor:</label>
                        <select id="doctor_id" name="doctor_id" required class="form-control">
                            <option value="">Select a doctor</option>
                            <?php
                            include_once 'connexion.php';  // Adjust path if needed
                            $conn = connectDB();

                            $sql = "SELECT id, name, specialization FROM doctor";
                            $result = mysqli_query($conn, $sql);

                            if (!$result) {
                                die("Query failed: " . mysqli_error($conn));
                            }

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . " - " . $row['specialization'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No doctors available</option>";
                            }
                            mysqli_close($conn);
                            ?>
                        </select>

                        <label for="status">Select Status:</label>
                        <select id="status" name="status" required class="form-control">
                            <option value="">Select a status</option>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                            <option value="on_leave">On Leave</option>
                        </select>

                        <label for="patient_name">Your Name:</label>
                        <input type="text" id="patient_name" name="patient_name" required class="form-control">

                        <label for="email">Your Email:</label>
                        <input type="email" id="email" name="email" required class="form-control">

                        <label for="appointment_date">Preferred Date:</label>
                        <input type="date" id="appointment_date" name="appointment_date" required class="form-control">
                        <br>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchBtn').addEventListener('click', function() {
            var email = document.getElementById('searchEmail').value.trim();

            if (email) {
                // Perform an AJAX request to filter appointments by email
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "filter_appointments.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Update the appointment list with the response
                        document.getElementById('appointmentTableBody').innerHTML = xhr.responseText;
                    }
                };

                xhr.send("email=" + encodeURIComponent(email));
            }
        });

        function editAppointment(data) {
            document.getElementById('appointment_id').value = data.id;
            document.getElementById('doctor_id').value = data.doctor_id || '';
            document.getElementById('patient_name').value = data.patient_name || '';
            document.getElementById('appointment_date').value = data.appointment_date || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('status').value = data.status || '';
        }

        function deleteAppointment(id) {
            var confirmed = confirm("Are you sure you want to delete this appointment?");
            if (confirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_appointment.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the response
                        console.log(xhr.responseText);
                    }
                };
                xhr.send("id=" + id);
            }
        }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>

</html>
