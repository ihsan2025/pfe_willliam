<?php
include '../../connexion.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectDB();
    $doctorName = $_POST['doctorName'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $consultancyFees = $_POST['consultancyFees'];

    // Hacher le mot de passe avec MD5
    $hashedPassword = md5($password);

    // Vérifier si la table "doctor" existe, sinon la créer
    $createTableSQL = "CREATE TABLE IF NOT EXISTS doctor (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        specialization VARCHAR(50) NOT NULL,
        phone VARCHAR(15) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        consultancy_fees DECIMAL(10, 2) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($createTableSQL) === TRUE) {
        // Préparer et exécuter la requête d'insertion
        $sql = "INSERT INTO doctor (name, specialization, phone, email, password, consultancy_fees) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssd", $doctorName, $specialization, $phone, $email, $hashedPassword, $consultancyFees);

        if ($stmt->execute()) {
            echo "<script>alert('Doctor added successfully.');</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error creating table: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            height: 90%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .form-group i {
            position: absolute;
            top: 35px;
            right: 10px;
            color: #aaa;
            font-size: 20px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #45a049;
        }

        .message {
            text-align: center;
            font-size: 18px;
            margin-bottom: 15px;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Doctor</h1>
        <form action="" method="POST">
            <div class="form-group">
                <label for="doctorName">Doctor Name</label>
                <input type="text" id="doctorName" name="doctorName" required>
                <i class="fas fa-user-md"></i>
            </div>
            <div class="form-group">
                <label for="specialization">Specialization</label>
                <select id="specialization" name="specialization" required>
                    <option value="general">General</option>
                    <option value="cardiologist">Cardiologist</option>
                    <option value="neurologist">Neurologist</option>
                    <option value="pediatrician">Pediatrician</option>
                </select>
                <i class="fas fa-stethoscope"></i>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" required>
                <i class="fas fa-phone"></i>
            </div>
            <div class="form-group">
                <label for="email">Email ID</label>
                <input type="email" id="email" name="email" required>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <i class="fas fa-lock"></i>
            </div>
            <div class="form-group">
                <label for="consultancyFees">Consultancy Fees</label>
                <input type="number" id="consultancyFees" name="consultancyFees" required>
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="form-group">
                <button type="submit">Add Doctor</button>
            </div>
        </form>
    </div>
</body>
</html>
