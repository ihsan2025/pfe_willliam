<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Appointment - Assist old person</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            position: relative;
            overflow: hidden;
        }

        .background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.5;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            transition: opacity 0.3s ease;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .close, .cancel-button {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            float: right;
            margin-left: 10px;
        }

        .close:hover, .close:focus, .cancel-button:hover, .cancel-button:focus {
            color: black;
            text-decoration: none;
        }

        .cancel-button {
            color: #dc3545; /* Red color for cancel button */
        }

        .cancel-button:hover {
            color: #c82333;
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        .modal.fade-in {
            display: block;
            opacity: 1;
        }

        .modal.fade-out {
            display: block;
            opacity: 0;
        }

    </style>
</head>
<body>

<video autoplay muted loop class="background-video">
    <source src="3197670-hd_1920_1080_25fps.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

<audio id="background-audio" autoplay loop>
    <source src="path/to/your/audio.mp3" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

<div id="appointmentModal" class="modal fade-in">
    <div class="modal-content">
        <span class="close" onclick="closeAppointmentModal()">&times;</span>
        <span class="cancel-button" onclick="cancelAppointment()">Cancel</span>
        <h2>Book an Appointment</h2>
        <form id="appointmentForm" action="process_appointment.php" method="POST">
            <label for="doctor">Select Doctor:</label>
            <select id="doctor" name="doctor" required>
                <option value="">Select a doctor</option>
                <?php
                include('./connexion.php');
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

            <form action="payment.html" method="get">
    <!-- Existing form fields -->
    <label for="name">Your Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Your Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="date">Preferred Date:</label>
    <input type="date" id="my-date" name="date" required min="">

    <!-- Button to redirect to payment page -->
    <button type="submit">Proceed to Payment</button>
</form>

    </div>
</div>

<script>
    function setMinDateToCurrentDate() {
        const today = new Date().toISOString().split("T")[0];
        document.getElementById("my-date").setAttribute("min", today);
    }

    function openAppointmentModal() {
        document.getElementById('appointmentModal').classList.add('fade-in');
        document.getElementById('appointmentModal').classList.remove('fade-out');
    }

    function closeAppointmentModal() {
        document.getElementById('appointmentModal').classList.add('fade-out');
        document.getElementById('appointmentModal').classList.remove('fade-in');
        setTimeout(() => {
            document.getElementById('appointmentModal').style.display = 'none';
        }, 300); // Match the transition duration
    }

    function cancelAppointment() {
        closeAppointmentModal();
        // Additional logic to handle the cancellation can be added here
        alert('Your appointment has been cancelled.');
    }

    document.addEventListener('DOMContentLoaded', () => {
        setMinDateToCurrentDate();
    });
</script>

</body>
</html>
