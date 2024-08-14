<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Sans&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .btn-outline-light:hover {
            color: #25bef7;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }

        .bg-primary {
            background: -webkit-linear-gradient(left, #3931af, #00c6ff);
        }

        .list-group-item.active {
            z-index: 2;
            color: #fff;
            background-color: #342ac1;
            border-color: #007bff;
        }

        .text-primary {
            color: #342ac1 !important;
        }

        button:hover,
        #inputbtn:hover {
            cursor: pointer;
        }
    </style>

    <title>Calendar Icon</title>
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
                                    <th scope="col">Appointment date</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Include the connection file
                                include 'connexion.php';

                                // Query to retrieve portfolio items
                                $sql = "SELECT * FROM appointment";
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
                                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                                        <td>
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                                            onclick="editDoctor(<?php echo htmlspecialchars(json_encode($row)); ?>)"
                                            >Edit</button>
                                            <button class="btn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                    <?php
      // Update appointment details
       include 'connexion.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
       $id = mysqli_real_escape_string($conn, $_POST['record_id']);
       $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor']);
       $name = mysqli_real_escape_string($conn, $_POST['name']);
       $email = mysqli_real_escape_string($conn, $_POST['email']);
       $date = mysqli_real_escape_string($conn, $_POST['date']);
       $status = mysqli_real_escape_string($conn, $_POST['status']);

       // Update query
       $sql = "UPDATE appointment SET doctor_id='$doctor_id', patient_name='$name', email='$email', appointment_date='$date', status='$status' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>

                                <?php
                                }
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
    <!-- <div> -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="processappo_intment.php" method="POST">
                        <label for="doctor">Select Doctor:</label>
                        <select id="doctor" name="doctor" required class="form-control">
                            <option>Select a doctor</option>
                            <?php
                                // include('./connexion.php');
                                $sql = "SELECT id, name, specialization FROM doctor";
                                $result = mysqli_query($conn,$sql);
                                if (!$result) {
                                    die("Query failed: " . mysqli_error($conn)); // Stop execution and display the error
                                }
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . " - " . $row['specialization'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No doctors available</option>";
                                }
                                // Close the connection
                                mysqli_close($conn);
                            ?>
                        </select>
                        <label for="doctor">Select Status:</label>
                        <select id="status" name="status" required class="form-control">
                            <option value="">Select a status</option>
                            <option value="available">Available</option>
                            <option value="unavailable">Unavailable</option>
                            <option value="on_leave">On Leave</option>
                            <!-- Add more status options if needed -->
                        </select>

                        <label for="name">Your Name:</label>
                        <input type="text" id="name" name="name" required class="form-control">

                        <label for="email">Your Email:</label>
                        <input type="email" id="email" name="email" required class="form-control">

                        <label for="date">Preferred Date:</label>
                        <input type="date" id="date" name="date" required class="form-control">
                        <br>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        function editDoctor(data) {
            console.log('data ===  ' , data);
            // Display the form
            // document.getElementById('editForm').style.display = 'block';

            // // Populate the form fields with the data
            document.getElementById('doctor').value = data.doctor_id;
            document.getElementById('name').value = data.patient_name;
            document.getElementById('date').value = data.appointment_date;
            document.getElementById('email').value = data.email;
            document.getElementById('status').value = data.status;
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