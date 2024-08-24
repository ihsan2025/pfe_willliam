<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            display: flex;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 10px;
            position: relative;
        }
        /* Specific styling for the Dashboard section */
        .dashboard-section {
            background-image: url('https://thumbs.dreamstime.com/b/beautiful-successful-female-doctor-13011820.jpg'); /* Replace with actual image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 20px;
            border-radius: 5px;
        }

        .header-logo {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .header-title {
            flex: 1;
            font-size: 24px;
        }

        .header-logout {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar ul li a:hover {
            background-color: #ddd;
        }

        .sidebar ul li a .icon {
            margin-right: 10px;
        }

        .sidebar ul li ul.sub-list {
            display: none;
            padding-left: 20px;
        }

        .sidebar ul li ul.sub-list.active {
            display: block;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        .iframe-container {
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Specific styling for the Doctor section */
        .doctor-section {
            background-image: url('https://example.com/path-to-your-doctor-background-image.jpg'); /* Replace with actual image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://cdn3.iconfinder.com/data/icons/elderly-old-folks-home/239/old-folks-home-elderly-care-007-512.png" alt="Assistant Old Person" class="header-logo">
        <div class="header-title">Administrator</div>
        <a href="../a_login.php" class="header-logout">Logout</a>
    </div>

    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php" target="main-frame"><i class="fas fa-tachometer-alt icon"></i>Dashboard</a></li>
                <li class="doctor-section">
                    <a href="#" class="toggle-sub-list"><i class="fas fa-user-md icon"></i>Doctor</a>
                    <ul class="sub-list">
                        <li><a href="add_doctor.php" target="main-frame"><i class="fas fa-user-plus icon"></i>Add Doctor</a></li>
                        <li><a href="list_doctor.php" target="main-frame"><i class="fas fa-list icon"></i>List of Doctors</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="toggle-sub-list"><i class="fas fa-procedures icon"></i>Patient</a>
                    <ul class="sub-list">
                        <li><a href="add_patient.php" target="main-frame"><i class="fas fa-user-plus icon"></i>Add Patient</a></li>
                        <li><a href="list_patient.php" target="main-frame"><i class="fas fa-list icon"></i>List of Patients</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="toggle-sub-list"><i class="fas fa-procedures icon"></i>License</a>
                    <ul class="sub-list">
                        <li><a href="add_license.php" target="main-frame"><i class="fas fa-user-plus icon"></i>Add License</a></li>
                        <li><a href="list_license.php" target="main-frame"><i class="fas fa-list icon"></i>List of Licenses</a></li>
                    </ul>
                </li>
                <li><a href="appointment.php" target="main-frame"><i class="fas fa-calendar-alt icon"></i>Appointment</a></li>
                <li><a href="appointment_list.php" target="main-frame"><i class="fas fa-calendar-alt icon"></i>Research_Appointment</a></li>
            </ul>
        </div>

        <div class="main-content">
            <iframe src="dashboard.php" name="main-frame" class="iframe-container"></iframe>
        </div>
    </div>

    <script>
        // JavaScript to toggle sub-list visibility
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSubListLinks = document.querySelectorAll('.toggle-sub-list');

            toggleSubListLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    const subList = this.nextElementSibling;
                    subList.classList.toggle('active');
                });
            });
        });
    </script>
</body>
