<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Health Center</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        header {
            position: relative;
            background: url('images/doctor2.jpg') no-repeat center center/cover;
            height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4); /* Adjust the darkness by changing the opacity */
            z-index: 1;
        }
        header h1, header p, header .btn, nav {
            position: relative;
            z-index: 2;
        }
        header h1 {
            font-size: 3rem;
            margin: 0;
        }
        header p {
            font-size: 1.5rem;
            margin: 10px 0;
        }
        header .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            margin-top: 20px;
            text-decoration: none;
        }
        header .btn:hover {
            background-color: #218838;
        }
        nav {
            position: absolute;
            top: 10px;
            right: 20px;
            background-color: transparent;
            padding: 10px 20px;
            border-radius: 5px;
            z-index: 2;
        }
        nav a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            color: #28a745;
        }
        .about-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 50px;
            background-color: white;
        }
        .about-content {
            max-width: 50%;
        }
        .about-content h2 {
            font-size: 2rem;
            color: #333;
        }
        .about-content p {
            font-size: 1rem;
            color: #555;
            margin: 10px 0;
        }
        .about-image {
            max-width: 50%;
        }
        .about-image img {
            width: 100%;
            border-radius: 10px;
        }
        .doctor-info {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        .doctor-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<header>
    <nav>
        <a href="Home.html">Home</a>
        <a href="About.html">About Us</a>
        <a href="doctors.html">Doctors</a>
        <a href="News.php">News</a>
        <a href="Contact.php">Contact</a>
        <a href="login.php" class="btn">Login</a>
    </nav>
    <h1>Healthy Living</h1>
    <p>Let's make your life happier</p>
    <a href="#" class="btn">Meet Our Doctors</a>
</header>

<div class="about-section">
    <div class="about-content">
        <h2>Welcome to Your Health Center</h2>
        <p>We provide dedicated care for the elderly, ensuring they lead happy and healthy lives. Our team of professionals is here to support and assist every step of the way.</p>
        <p>With personalized care plans and a compassionate approach, we aim to enhance the quality of life for every individual we serve.</p>
        <div class="doctor-info">
            <img src="images/doctor.jpg" alt="Dr. Neil Jackson">
            <span>
                <strong>Dr. Neil Jackson</strong><br>
                General Principal
            </span>
        </div>
    </div>
    <div class="about-image">
        <img src="images/doctor3.jpg" alt="Healthcare Professional">
    </div>
</div>

</body>
</html>
