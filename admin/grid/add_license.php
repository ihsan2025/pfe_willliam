<?php
include '../../connexion.php';

$conn = connectDB();

// Create the licenses table if it doesn't exist
$table_creation_query = "
CREATE TABLE IF NOT EXISTS licenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_name VARCHAR(255) NOT NULL,
    license_number VARCHAR(255) NOT NULL,
    approved TINYINT(1) DEFAULT 0
)";

if ($conn->query($table_creation_query) === FALSE) {
    echo "<script>alert('Error creating table: " . $conn->error . "');</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['pdf_file'])) {
    $pdf_file = $_FILES['pdf_file'];

    // Check if file is a PDF
    if ($pdf_file['type'] == 'application/pdf') {
        // Handle the PDF file and extract data
        $pdf_path = $pdf_file['tmp_name'];

        // Use a library like TCPDF, FPDF, or another to extract text from the PDF
        // Here, we'll use a hypothetical function extractDoctorNameAndLicenseNumberFromPdf
        list($doctor_name, $license_number) = extractDoctorNameAndLicenseNumberFromPdf($pdf_path);

        if ($doctor_name && $license_number) {
            // Insert data into the database
            $sql = "INSERT INTO licenses (doctor_name, license_number) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $doctor_name, $license_number);

            if ($stmt->execute()) {
                echo "<script>alert('License has been successfully added.');</script>";
            } else {
                echo "<script>alert('Error adding license: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Failed to extract data from the PDF.');</script>";
        }
    } else {
        echo "<script>alert('Please upload a valid PDF file.');</script>";
    }
}

$conn->close();

// Hypothetical function to extract doctor name and license number from PDF
function extractDoctorNameAndLicenseNumberFromPdf($pdf_path) {
    // Extract file name from the path
    $file_name = basename($pdf_path);
    
    // Implement PDF text extraction here
    // For simplicity, let's assume it returns a tuple with doctor name and license number
    $doctor_name = '';  // Replace with actual extraction logic
    $license_number = '';  // Replace with actual extraction logic
    return [
        'file_name' => $file_name,
        'doctor_name' => $doctor_name,
        'license_number' => $license_number
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add License</title>
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
            max-width: 600px;
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

        .form-group input[type="file"] {
            display: block;
            width: 100%;
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

        .feedback {
            margin-top: 15px;
            font-size: 16px;
            color: #d9534f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add License</h1>
        <form id="licenseForm" action="add_license.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="pdf_file">Upload PDF</label>
                <input type="file" id="pdf_file" name="pdf_file" accept=".pdf" required>
            </div>
            <div class="form-group">
                <button type="submit">Add License</button>
            </div>
            <div id="feedback" class="feedback"></div>
        </form>
    </div>
    <script>
        document.getElementById('licenseForm').addEventListener('submit', function(event) {
            var fileInput = document.getElementById('pdf_file');
            var feedback = document.getElementById('feedback');

            if (!fileInput.files.length) {
                feedback.textContent = 'Please select a PDF file.';
                event.preventDefault();
                return;
            }

            var file = fileInput.files[0];
            if (file.type !== 'application/pdf') {
                feedback.textContent = 'Only PDF files are allowed.';
                event.preventDefault();
                return;
            }

            feedback.textContent = ''; // Clear feedback
        });
    </script>
</body>
</html>
