<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment - Assist Old Person</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Your existing styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #343a40;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }
        nav .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        nav .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        nav .nav-links a:hover {
            color: #28a745;
        }
        nav .cta {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        nav .cta:hover {
            background-color: #218838;
        }
        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 50px auto;
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group input[type="date"], .form-group input[type="time"] {
            padding: 8px;
        }
        .form-group select {
            cursor: pointer;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #218838;
        }
        .response-message {
            margin-top: 20px;
            color: #333;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">Health Center</div>
    <ul class="nav-links">
        <li><a href="accueil.php">Home</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Doctors</a></li>
        <li><a href="#">News</a></li>
        <li><a href="#">Contact</a></li>
        <li><a href="appointment.php">Make an appointment</a></li>
        <li><a href="../accueil.php" class="cta">Logout</a></li>
    </ul>
</nav>

<div class="container">
    <h2>Book an Appointment</h2>
    <form id="appointment-form">
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" id="time" name="time" required>
        </div>
        <div class="form-group">
            <label for="doctor">Doctor</label>
            <select id="doctor" name="doctor" required>
                <option value="">Select a Doctor</option>
                <?php
                include('../connexion.php');
                $conn = connectDB(); // Ensure the function is defined in your connexion.php file
                $sql = "SELECT id, name, specialization FROM doctor";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . " - " . $row['specialization'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No doctors available</option>";
                }
                $conn->close();
                ?>
            </select>
        </div>
        <button type="submit" class="btn">Submit</button>
    </form>
    <div id="response-message" class="response-message"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('appointment-form');
    const responseMessage = document.getElementById('response-message');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting traditionally
        
        const formData = new FormData(form);
        
        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '', true); // Sending to the same file
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Display the response message
                responseMessage.innerHTML = `
                    <h3>Appointment Details</h3>
                    <p><strong>Date:</strong> ${formData.get('date')}</p>
                    <p><strong>Time:</strong> ${formData.get('time')}</p>
                    <p><strong>Doctor:</strong> ${formData.get('doctor')}</p>
                `;
            } else {
                responseMessage.innerHTML = '<p style="color: red;">Failed to submit appointment.</p>';
            }
        };
        
        // Send the request with form data
        xhr.send(formData);
    });
});
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../connexion.php');
    $conn = connectDB();

    $date = $_POST['date'];
    $time = $_POST['time'];
    $doctor_id = $_POST['doctor']; // Using doctor ID to reference the doctor

    // Query to insert the appointment into the database
    $sql = "INSERT INTO appointments (date, time, doctor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $date, $time, $doctor_id);

    if ($stmt->execute()) {
        echo "<div class='response-message'>
                <h3>Appointment Details</h3>
                <p><strong>Date:</strong> $date</p>
                <p><strong>Time:</strong> $time</p>
                <p><strong>Doctor:</strong> " . htmlspecialchars($_POST['doctor']) . "</p>
              </div>";
    } else {
        echo "<div class='response-message' style='color: red;'>Failed to book the appointment. Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
