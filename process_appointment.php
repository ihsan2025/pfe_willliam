<?php
include('./connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $doctor_id = $_POST['doctor'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $date = $_POST['date'];

    // Validate form data (basic validation)
    // if (empty($doctor) || empty($name) || empty($email) || empty($date)) {
    //     die("Please fill out all required fields.");
    // }
      // Debugging: Check if any field is empty
    if (empty($doctor_id)) {
        echo "Doctor ID is empty.<br>";
    }
    if (empty($name)) {
        echo "Name is empty.<br>";
    }
    if (empty($email)) {
        echo "Email is empty.<br>";
    }
    if (empty($date)) {
        echo "Date is empty.<br>";
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