<?php
include '../../connexion.php';

$conn = connectDB();

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Delete the doctor from the database
    $sql = "DELETE FROM doctor WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Doctor has been successfully deleted.');</script>";
    } else {
        echo "<script>alert('Error deleting doctor.');</script>";
    }

    $stmt->close();
}

// Fetch doctor data
$sql = "SELECT id, name, specialization, phone, email, consultancy_fees FROM doctor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Doctors</title>
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
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-radius: 2%;
            overflow: hidden; /* Ensures the border-radius is applied properly */
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions a {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .delete-btn:hover {
            background-color: #e53935;
        }
    </style>
    <script>
        function confirmDelete(doctorId, doctorName, doctorSpecialization) {
            if (confirm(`Do you want to delete Dr. ${doctorName}, who is a ${doctorSpecialization}?`)) {
                window.location.href = `list_doctor.php?delete_id=${doctorId}`;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>List of Doctors</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Consultancy Fees</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $id = htmlspecialchars($row['id']);
                        $name = htmlspecialchars($row['name']);
                        $specialization = htmlspecialchars($row['specialization']);
                        $phone = htmlspecialchars($row['phone']);
                        $email = htmlspecialchars($row['email']);
                        $consultancy_fees = htmlspecialchars($row['consultancy_fees']);
                        
                        echo "<tr>";
                        echo "<td>$name</td>";
                        echo "<td>$specialization</td>";
                        echo "<td>$phone</td>";
                        echo "<td>$email</td>";
                        echo "<td>$consultancy_fees</td>";
                        echo "<td class='actions'>";
                        echo "<a href='edit_doctor.php?id=$id' class='edit-btn'><i class='fas fa-edit'></i> Edit</a>";
                        echo "<a href='#' class='delete-btn' onclick='confirmDelete(\"$id\", \"$name\", \"$specialization\")'><i class='fas fa-trash-alt'></i> Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No doctors found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
