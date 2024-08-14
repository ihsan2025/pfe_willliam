<?php
$successMessage = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize variables
    $name = $email = $message = '';
    
    // Validate and sanitize form inputs
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email format';
        } else {
            // Prepare email
            $to = 'your@email.com'; // Replace with your email address
            $subject = 'Contact Form Submission';
            $headers = "From: $name <$email>\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            // Send email
            if (mail($to, $subject, $message, $headers)) {
                $successMessage = 'Your message has been sent successfully!';
            } else {
                $error = 'Failed to send your message. Please try again later.';
            }
        }
    } else {
        $error = 'All fields are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .contact-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
        }
        .contact-form h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .contact-form label {
            display: block;
            margin-bottom: 8px;
        }
        .contact-form input[type="text"],
        .contact-form input[type="email"],
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .contact-form textarea {
            resize: vertical;
            height: 150px;
        }
        .contact-form button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .contact-form button:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
        .error {
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="contact-form">
        <h2>Contact Us</h2>
        <form action="" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>
            
            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Your Message" required></textarea>
            
            <button type="submit">Send Message</button>
            
            <?php if (!empty($successMessage)) : ?>
                <div class="message"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($error)) : ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
