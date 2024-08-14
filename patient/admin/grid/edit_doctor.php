<?php
include '../../connexion.php';

$conn = connectDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch doctor data
    $sql = "SELECT name, specialization, phone, email, consultancy_fees FROM doctor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name, $specialization, $phone, $email, $consultancy_fees);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $consultancy_fees = $_POST['consultancy_fees'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password_hashed = md5($password);
        // Update doctor data with password
        $sql = "UPDATE doctor SET name = ?, specialization = ?, phone = ?, email = ?, consultancy_fees = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $name, $specialization, $phone, $email, $consultancy_fees, $password_hashed, $id);
    } else {
        // Update doctor data without password
        $sql = "UPDATE doctor SET name = ?, specialization = ?, phone = ?, email = ?, consultancy_fees = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $specialization, $phone, $email, $consultancy_fees, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Doctor has been successfully updated.'); window.location.href='list_doctor.php';</script>";
    } else {
        echo "<script>alert('Error updating doctor.');</script>";
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
    <title>Edit Doctor</title>
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
        <h1>Edit Doctor</h1>
        <form action="edit_doctor.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="form-group">
                <label for="specialization">Specialization</label>
                <select id="specialization" name="specialization" required>
                    <option value="general" <?php if ($specialization == 'general') echo 'selected'; ?>>General</option>
                    <option value="cardiologist" <?php if ($specialization == 'cardiologist') echo 'selected'; ?>>Cardiologist</option>
                    <option value="neurologist" <?php if ($specialization == 'neurologist') echo 'selected'; ?>>Neurologist</option>
                    <option value="pediatrician" <?php if ($specialization == 'pediatrician') echo 'selected'; ?>>Pediatrician</option>
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="consultancy_fees">Consultancy Fees</label>
                <input type="number" id="consultancy_fees" name="consultancy_fees" value="<?php echo htmlspecialchars($consultancy_fees); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <small>Leave blank if you do not want to change the password.</small>
            </div>
            <div class="form-group">
                <button type="submit">Update Doctor</button>
            </div>
        </form>
    </div>
</body>
</html>
