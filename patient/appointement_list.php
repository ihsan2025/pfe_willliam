<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Calendar Icon</title>
    <!-- Add necessary stylesheets and scripts -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
</head>

<body style="padding-top: 50px;">
    <div class="container">
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
                            <tbody>
                                <?php
                                include_once '../connexion.php';  // Adjust path if needed

                                // Establish connection
                                $conn = connectDB();

                                // Query to retrieve appointments
                                $sql = "SELECT a.doctor_id, a.id, a.patient_name, a.email, a.appointment_date, a.status, d.name AS doctor_name FROM appointment AS a JOIN doctor AS d ON a.doctor_id = d.id";
                                $result = mysqli_query($conn, $sql);

                                // Check if query was successful
                                if (!$result) {
                                    die("Query failed: " . mysqli_error($conn));
                                }

                                // Fetch and display the results
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                                                onclick="editAppointment(<?php echo htmlspecialchars(json_encode($row)); ?>)">Edit</button>
                                            <button class="btn btn-danger" onClick="deleteAppointment(<?php echo htmlspecialchars($row['id']); ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                mysqli_close($conn);
                                ?>
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

                        <label for="doctor_id">Select Doctor:</label>
                        <select id="doctor_id" name="doctor_id" required class="form-control">
                            <option value="">Select a doctor</option>
                            <?php
                            // Include the connection again to fetch doctors
                            include_once '../connexion.php';  // Adjust path if needed
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
        function editAppointment(data) {
            console.log('data ===  ', data);
            document.getElementById('appointment_id').value = data.id;
            document.getElementById('doctor_id').value = data.doctor_id || '';
            document.getElementById('patient_name').value = data.patient_name || '';
            document.getElementById('appointment_date').value = data.appointment_date || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('status').value = data.status || '';
        }

        function deleteAppointment(id) {
            // Prompt the user with a confirmation dialog
            var confirmed = confirm("Are you sure you want to delete this appointment?");
            if (confirmed) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_appointment.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the response (e.g., remove the row from the table)
                        console.log(xhr.responseText);
                    }
                };
                xhr.send("id=" + id);
            } else {
                // If the user clicks "Cancel", do nothing
                console.log("Deletion canceled.");
            }
        }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
</body>

</html>