<?php
include '../../connexion.php';

$conn = connectDB();

// Fetch all licenses from the database
$sql = "SELECT * FROM licenses";
$result = $conn->query($sql);

if ($result === FALSE) {
    echo "<script>alert('Error retrieving licenses: " . $conn->error . "');</script>";
    exit;
}

$licenses = [];
while ($row = $result->fetch_assoc()) {
    $licenses[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Licenses</title>
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
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
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
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .no-data {
            text-align: center;
            color: #555;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>List of Licenses</h1>
        <?php if (count($licenses) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Doctor Name</th>
                        <th>License Number</th>
                        <th>Approved</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($licenses as $license): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($license['id']); ?></td>
                            <td><?php echo htmlspecialchars($license['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($license['license_number']); ?></td>
                            <td><?php echo $license['approved'] ? 'Yes' : 'No'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">No licenses found.</div>
        <?php endif; ?>
    </div>
</body>
</html>
