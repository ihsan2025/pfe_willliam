<?php
include '../../connexion.php';

$conn = connectDB();

// Create the patient table if it doesn't exist
$table_creation_query = "
CREATE TABLE IF NOT EXISTS patient (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    sex ENUM('female', 'male') NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($table_creation_query) === FALSE) {
    echo "<script>alert('Error creating table: " . $conn->error . "');</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $first_name = $_POST['first_name'];
    $address = $_POST['address'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password

    // Insert patient data into the database
    $sql = "INSERT INTO patient (name, first_name, address, sex, email, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $first_name, $address, $sex, $email, $password);

    if ($stmt->execute()) {
        echo "<script>alert('Patient has been successfully added.');</script>";
    } else {
        echo "<script>alert('Error adding patient.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
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
            width: 100vw;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Patient</h1>
        <form action="add_patient.php" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="sex">Sex</label>
                <select id="sex" name="sex" required>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Patient</button>
            </div>
        </form>
    </div>
</body>
</html>
