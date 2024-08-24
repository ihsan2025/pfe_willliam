<?php
include('./connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $doctor_id = isset($_POST['doctor']) ? $_POST['doctor'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';

    // Validate form data (basic validation)
    if (empty($doctor_id) || empty($name) || empty($email) || empty($date)) {
        die("Please fill out all required fields.");
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO appointment (doctor_id, patient_name, email, appointment_date) VALUES (?, ?, ?, ?)");

    // Check if prepare() failed
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("isss", $doctor_id, $name, $email, $date);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
