<?php
// Include the database connection file
require_once '../connexion.php';

// Initialize error message variable
$error_message = '';

// Check if email and password fields are submitted
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Convert the password to MD5

    // Escape the values to avoid SQL injections
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // SQL query to check email and password in the 'admin' table
    $query = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query returned a row (match found)
    if (mysqli_num_rows($result) == 1) {
        // Authentication successful, redirect to a_dashboard.php
        header("Location: grid/a_dashboard.php");
        exit();
    } else {
        // Authentication failed, set error message
        $error_message = "Incorrect email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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

        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .input-group {
            width: 100%;
            margin-bottom: 15px;
            position: relative;
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
            display: block;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.2);
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 14px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin-top: 20px;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login-form">
            <img src="../images/logo.png" alt="Hospital Logo" class="logo">
            <h2>Admin Login</h2>
            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
