<?php
include "includes/header.php";
include "includes/usernavbar.php";
?>

<?php
include 'connection.php';
$driverName;
$driverEmail;
$driverContactNumber;

// Assuming you have a 'did' parameter in the URL
if (isset($_GET['id'])) {
    $driverId = $_GET['id'];

    // Query to retrieve the driver's information
    $driverQuery = "SELECT * FROM driver_details WHERE driver_id = '$driverId'";
    $driverResult = mysqli_query($con, $driverQuery);

    // Check if the query was successful
    if ($driverResult) {
        // Fetch the driver's information
        $driverData = mysqli_fetch_assoc($driverResult);

        // Check if the driver was found
        if ($driverData) {
            $driverName = $driverData['driver_name'];
            $driverEmail = $driverData['email'];
            $driverContactNumber = $driverData['phone_number'];

        }
    }
}
?>


<div class="bg-image"
    style="background-image: url(https://img.freepik.com/free-vector/ambulance-doctors-concept-emergency-doctor-uniform-paramedics-urgent-care-healthcare-modern-medicine-treatment-isolated-vector-illustration_613284-2665.jpg?w=900&t=st=1706953610~exp=1706954210~hmac=f8b3f4d9ad702208081a8a703157327ce27c00327cca390e70f58c2e519e18a3);">
    <div class="page-section">
        <div class="container"
            style="background-color: #e1e0e0; border: 10%; padding-top: 30px; padding-left: 30px; padding-right: 30px; padding-bottom: 30px; backdrop-filter: blur(8px); border-radius: 15px;">
            <p class="text-start text-capitalize text-success">
                <a href="doctors.php" class="text-decoration-none">Driver </a>
                <?= $driverName; ?>

            </p>
            <hr>
            <form class="contact-form mt-5" method="post">
                <div class="row mb-3">
                    <div class="col-sm-6 py-2 wow fadeInRight">
                        <label for="DateTime">Date and Time</label>
                        <input type="datetime-local" name="DateTime" class="form-control" required>
                    </div>
                    <div class="col-12 py-2 wow fadeInUp">
                        <label for="PickupLocation">Pick-up Location</label>
                        <input type="text" name="PickupLocation" class="form-control"
                            placeholder="Enter Pickup Location" required>
                    </div>
                    <div class="col-12 py-2 wow fadeInUp">
                        <label for="DropoffLocation">Drop-off Location</label>
                        <input type="text" name="DropoffLocation" class="form-control"
                            placeholder="Enter Drop-off Location" required>
                    </div>
                    <div class="col-12 py-2 wow fadeInUp">
                        <label for="ServiceType">Service Type</label>
                        <select name="ServiceType" class="form-control" required>
                            <option value="">Choose Service Type</option>
                            <option value="Emergency">Emergency</option>
                            <option value="Non-emergency">Non-emergency</option>
                        </select>
                    </div>
                    <div class="col-12 py-2 wow fadeInUp">
                        <label for="SpecialInstructions">Special Instructions</label>
                        <textarea name="SpecialInstructions" class="form-control" rows="2"
                            placeholder="Any special instructions for the driver.."></textarea>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary wow zoomIn">Book Now</button>
            </form>
        </div>
    </div>
</div>

</body>

</html>
<?php
include 'connection/connection.php';  // Include your database connection file

// Include PHPMailer autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    // Get values from the form
    $dateTime = $_POST['DateTime'];
    $pickupLocation = $_POST['PickupLocation'];
    $dropoffLocation = $_POST['DropoffLocation'];
    $serviceType = $_POST['ServiceType'];
    $specialInstructions = $_POST['SpecialInstructions'];

    // Assuming you have a 'user_email' cookie
    $userEmail = isset($_COOKIE['user_email']) ? $_COOKIE['user_email'] : '';

    // Check if a booking already exists for the specified driver and user
    $checkBookingQuery = "SELECT * FROM bookingdetails WHERE driver_email = '$driverEmail' AND user_email = '$userEmail'";
    $checkBookingResult = mysqli_query($con, $checkBookingQuery);

    if (mysqli_num_rows($checkBookingResult) > 0) {
        // Alert for already booked driver
        echo "<script>alert('This driver is already booked by you.');</script>";
    } else {
        // Insert data into the database
        $insertQuery = "INSERT INTO bookingdetails (user_email, driver_email, ContactNumber, driver_name, DateTime, PickupLocation, DropoffLocation, ServiceType, SpecialInstructions) 
                        VALUES ('$userEmail', '$driverEmail', '$driverContactNumber', '$driverName', '$dateTime', '$pickupLocation', '$dropoffLocation', '$serviceType', '$specialInstructions')";

        $result = mysqli_query($con, $insertQuery);

        if ($result) {
            // Send an email to the user using PHPMailer
            $mail = new PHPMailer(true);  // Passing true enables exceptions

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'aadiipatil10z@gmail.com';  // Replace with your Gmail email address
                $mail->Password = 'bbnl lppt pnvj ahdg';   // Replace with your Gmail password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('aadiipatil10z@gmail.com', 'Tech Care');  // Replace with your Gmail email address and name
                $mail->addAddress($userEmail);  // Add recipient email

                $mail->isHTML(true);
                $mail->Subject = "Ambulance Booking Confirmation";
                $mail->Body = "
    <html>
    <head>
        <style>
            /* Add your custom styles here */
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f4f4;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #007BFF;
            }
            /* Add more styles as needed */
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Your Ambulance Booking Details</h2>
            <p>Dear User,</p>
            <p>Your ambulance has been booked with the following details:</p>
            <ul>
                <li><strong>Driver Name:</strong> $driverName</li>
                <li><strong>Date and Time:</strong> $dateTime</li>
                <li><strong>Pick-up Location:</strong> $pickupLocation</li>
                <li><strong>Driver Phone Number:</strong> $driverContactNumber</li>
                <li><strong>Drop-off Location:</strong> $dropoffLocation</li>
                <li><strong>Service Type:</strong> $serviceType</li>
                <li><strong>Fees:</strong>  (Paid)</li>
            </ul>
            <p>Thank you for choosing our ambulance service!</p>
        </div>
    </body>
    </html>
";

                $mail->send();

                // Show popup message and redirect to the previous page
                echo "<script>
              alert('Driver has been booked. Check your email for more details.');
              window.location.href = 'ambulance.php';
            </script>";
            } catch (Exception $e) {
                echo "Error sending email: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}
?>