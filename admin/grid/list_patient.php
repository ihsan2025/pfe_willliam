<?php
include '../../connexion.php';

$conn = connectDB();

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Delete the patient from the database
    $sql = "DELETE FROM patient WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Patient has been successfully deleted.');</script>";
    } else {
        echo "<script>alert('Error deleting patient.');</script>";
    }

    $stmt->close();
}

// Fetch patient data
$sql = "SELECT id, name, first_name, address, sex, email FROM patient";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Patients</title>
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
        function confirmDelete(patientId, patientName) {
            if (confirm(`Do you want to delete the patient ${patientName}?`)) {
                window.location.href = `list_patient.php?delete_id=${patientId}`;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>List of Patients</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>First Name</th>
                    <th>Address</th>
                    <th>Sex</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $id = htmlspecialchars($row['id']);
                        $name = htmlspecialchars($row['name']);
                        $first_name = htmlspecialchars($row['first_name']);
                        $address = htmlspecialchars($row['address']);
                        $sex = htmlspecialchars($row['sex']);
                        $email = htmlspecialchars($row['email']);
                        
                        echo "<tr>";
                        echo "<td>$name</td>";
                        echo "<td>$first_name</td>";
                        echo "<td>$address</td>";
                        echo "<td>$sex</td>";
                        echo "<td>$email</td>";
                        echo "<td class='actions'>";
                        echo "<a href='edit_patient.php?id=$id' class='edit-btn'><i class='fas fa-edit'></i> Edit</a>";
                        echo "<a href='#' class='delete-btn' onclick='confirmDelete(\"$id\", \"$name\")'><i class='fas fa-trash-alt'></i> Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No patients found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
