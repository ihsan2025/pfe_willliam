<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles for the dashboard page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px; /* Adjusted padding to make the header smaller */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 60px; /* Adjusted height to make the header smaller */
        }

        .header-logo {
            width: 40px; /* Adjusted size to make the logo smaller */
            border-radius: 50%;
            animation: jump 2s infinite;
            filter: invert(100%) brightness(0%) contrast(100%);
        }

        @keyframes jump {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
            }
        }

        .header-title {
            font-size: 20px; /* Adjusted font size to make the title smaller */
            font-weight: bold;
        }

        .header-logout {
            cursor: pointer;
            color: white;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .header-logout:hover {
            opacity: 0.8;
        }

        .container {
            display: flex;
            flex: 1;
            height: calc(100vh - 60px); /* Adjusted according to new header height */
        }

        .sidebar {
            background-color: #ffffff;
            width: 250px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 20px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            transition: color 0.3s ease, background-color 0.3s ease;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
        }

        .sidebar ul li a:hover {
            background-color: #4CAF50;
            color: white;
        }

        .sidebar ul li a .icon {
            margin-right: 10px;
        }

        .sidebar .sub-list {
            display: none;
            padding-left: 20px;
        }

        .sidebar .sub-list.active {
            display: block;
        }

        .sidebar .sub-list li a {
            font-size: 16px;
        }

        .main-content {
            flex: 1;
            padding: 0;
        }

        .iframe-container {
            width: 100%;
            height: 100%;
            border: none;
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
                <li>
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
                <li><a href="appointments.php" target="main-frame"><i class="fas fa-calendar-alt icon"></i>Appointment</a></li>
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
</html>
