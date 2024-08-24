<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        nav {
            background-color: #007bff;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: center;
            gap: 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .header {
            background: url('../images/doctor4.jpg') no-repeat center center;
            background-size: cover;
            height: 100vh;
            color: white;
            text-align: center;
            position: relative;
            animation: backgroundMove 10s infinite alternate;
            margin-top: 50px;
        }
        @keyframes backgroundMove {
            0% { background-position: center; }
            100% { background-position: left; }
        }
        .header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }
        .header-content {
            position: relative;
            z-index: 2;
            top: 50%;
            transform: translateY(-50%);
        }
        .header h1 {
            margin: 0;
            font-size: 3rem;
        }
        .header p {
            font-size: 1.5rem;
            margin-top: 20px;
        }
        .services, .portfolio {
            padding: 50px 20px;
            text-align: center;
        }
        .services {
            background-color: #007bff;
            color: white;
        }
        .services h2, .portfolio h2 {
            margin-top: 0;
            font-size: 2rem;
        }
        .service-items, .portfolio-items {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .service-item, .portfolio-item {
            background: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            min-width: 200px;
            max-width: 220px;
            color: #333;
        }
        .service-item i, .portfolio-item img {
            display: block;
            margin: 0 auto 10px;
            font-size: 2rem;
        }
        .portfolio-item img {
            width: 100%;
            height: auto;
        }
        .info {
            padding: 10px;
        }
        .info h3 {
            margin-top: 0;
        }
        .links a {
            margin-right: 10px;
        }
        .video-container iframe {
            width: 100%;
            height: 315px;
        }
        /* Modal Styles */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0; 
    top: 0; 
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

button {
    margin-top: 10px;
}
.Doctor2 img {
            width: 40%;
            border-radius: 10px;}
            .Doctor3 img {
            width: 40%;
            border-radius: 10px;}
            .Doctor1 img {
            width: 400%;
            border-radius: 10px;}
            .Doctor4 img {
            width: 40%;
            border-radius: 10px;}

    </style>
    <script>
    
    
    function openAppointmentModal(doctorName) {
    document.getElementById('doctor').value = doctorName;
    document.getElementById('appointmentModal').style.display = 'block';
}

function closeAppointmentModal() {
    document.getElementById('appointmentModal').style.display = 'none';
}

// Handle form submission
document.getElementById('appointmentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => { data[key] = value; });

    console.log('Appointment Request:', data);

    // You can add your logic here to send form data to your server or API

    // Close the modal after submission
    closeAppointmentModal();
});

</script>
</head>
<body>

<nav>
    <a href="Home.html">Home</a>
    <a href="services.html">Services</a>
    <a href="about.html">About Us</a>
    <a href="portfolio.html">Portfolio</a>
    <a href="team.html">Team</a>
    <a href="contact.html">Contact Us</a>
    <a href="appointement_list.php">Appointement schedule</a>
</nav>

<div class="header" id="home">
    <div class="header-content">
        <h1>Doctor</h1>
        <p>BELIEF IN RECOVERY ALWAYS</p>
    </div>
</div>

<div class="services" id="services">
    <h2>Our Services</h2>
    <p>At lorem ipsum available, but the majority have suffered alteration in some form by injected humour.</p>
    <div class="service-items">
        <div class="service-item">
            <i class="fas fa-user-md"></i>
            <h3>Critical Monitoring</h3>
            <p>Nullam ac rhoncus sapien, nec aliquam nisl.</p>
        </div>
        <div class="service-item">
            <i class="fas fa-heartbeat"></i>
            <h3>Medical Treatment</h3>
            <p>Aenean in odio imperdiet, congue ligula vitae.</p>
        </div>
        <div class="service-item">
            <i class="fas fa-female"></i>
            <h3>Elderly Woman Care</h3>
            <p>Donec congue, magna at tristique imperdiet.</p>
        </div>
        <div class="service-item">
            <i class="fas fa-child"></i>
            <h3>70+ Care</h3>
            <p>Integer vel eros vestibulum, ultrices ligula.</p>
        </div>
    </div>
</div>

<div class="portfolio" id="portfolio">
    <h2>Our Doctors</h2>
    <div class="portfolio-items">
        <div class="portfolio-item">
            <img src="../images/doctor1.jpg" alt="Doctor 1">
            <div class="info">
                <h3>Doctor 1</h3>
                <p>Speciality: Cardiology</p>
                <button onclick="openAppointmentModal('Doctor 1')">Make an Appointment</button>
            </div>
        </div>
        <div class="portfolio-item">
            <img src="../images/doctor2.jpg" alt="Doctor 2">
            <div class="info">
                <h3>Doctor 2</h3>
                <p>Speciality: Neurology</p>
                <button onclick="openAppointmentModal('Doctor 2')">Make an Appointment</button>
            </div>
        </div>
        <div class="portfolio-item">
            <img src="../images/doctor3.jpg" alt="Doctor 3">
            <div class="info">
                <h3>Doctor 3</h3>
                <p>Speciality: Orthopedics</p>
                <button onclick="openAppointmentModal('Doctor 3')">Make an Appointment</button>
            </div>
        </div>
        <div class="portfolio-item">
            <img src="../images/doctor4.jpg" alt="Doctor 4">
            <div class="info">
                <h3>Doctor 4</h3>
                <p>Speciality: Pediatrics</p>
                <button onclick="openAppointmentModal('Doctor 4')">Make an Appointment</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAppointmentModal()">&times;</span>
        <h2>Book an Appointment</h2>
        <form id="appointmentForm" action="process_appointment.php" method="POST">
            <label for="doctor">Select Doctor:</label>
            <select  id="doctor" name="doctor" required >
                <option>Select a doctor</option>
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
            
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="date">Preferred Date:</label>
            <input type="date" id="my-date" name="date" required min="">
            
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>

<script>
        // Set the min attribute to today's date
        function setMinDateToCurrentDate() {
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("my-date").setAttribute("min", today);
        }
        setMinDateToCurrentDate();
</script>

</body>
</html>
