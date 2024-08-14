<?php
include('C:/xampp/htdocs/pfe_william/connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if POST variables are set
    if (isset($_POST['doctor_id']) && isset($_POST['patient_name']) && isset($_POST['email']) && isset($_POST['appointment_date'])) {
        // Get form data
        $doctor_id = $_POST['doctor_id'];
        $name = $_POST['patient_name'];
        $email = $_POST['email'];
        $date = $_POST['appointment_date'];
        $status = $_POST['status'];
        $appointment_id = $_POST['appointment_id'];

        // Validate form data
        $errors = [];
        if (empty($doctor_id)) $errors[] = "Doctor ID is empty.";
        if (empty($name)) $errors[] = "Name is empty.";
        if (empty($email)) $errors[] = "Email is empty.";
        if (empty($date)) $errors[] = "Date is empty.";

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
            exit; // Stop execution if there are errors
        }

        // Prepare SQL statement
        if (!isset($conn) || $conn === null) {
            die("Connection not established.");
        }

        // Update the appointment
        $stmt = $conn->prepare("UPDATE appointment SET doctor_id = ?, patient_name = ?, email = ?, appointment_date = ?, status = ? WHERE id = ?");

        // Check if prepare() failed
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        // Bind parameters and execute
        $stmt->bind_param("issssi", $doctor_id, $name, $email, $date, $status, $appointment_id);

        if ($stmt->execute()) {
            echo "Appointment updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Required POST variables are missing.";
    }
} else {
    echo "Invalid request method.";
}
?>
