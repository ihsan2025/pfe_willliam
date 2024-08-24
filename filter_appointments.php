<?php
include_once 'connexion.php';  // Adjust path if needed

// Establish connection
$conn = connectDB();

// Get the searched email
$email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';

// Query to retrieve filtered appointments
$sql = "SELECT a.doctor_id, a.id, a.patient_name, a.email, a.appointment_date, a.status, d.name AS doctor_name
        FROM appointment AS a
        JOIN doctor AS d ON a.doctor_id = d.id
        WHERE a.email LIKE '%$email%'";

$result = mysqli_query($conn, $sql);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch and display the results
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['appointment_date']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
    echo "<td>
            <button class='btn btn-primary' data-toggle='modal' data-target='#myModal'
                onclick='editAppointment(" . htmlspecialchars(json_encode($row)) . ")'>Edit</button>
            <button class='btn btn-danger' onClick='deleteAppointment(" . htmlspecialchars($row['id']) . ")'>Delete</button>
          </td>";
    echo "</tr>";
}

mysqli_close($conn);
?>
