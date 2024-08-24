<?php

// Initialiser la session si ce n'est pas déjà fait
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['username']; // Utiliser 'username' pour email dans le formulaire
    $password = md5($_POST['password']); // Convertir le mot de passe en MD5

    // Inclure le fichier de connexion à la base de données
    require_once('connexion.php');

    // Préparer la requête pour vérifier les informations de connexion
    $sql = "SELECT * FROM patient WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Authentification réussie
        $_SESSION['email'] = $email; // Stocker l'email dans la session si nécessaire

        // Redirection vers la page d'accueil du patient
        header("Location: patient/accueil.php");
        exit();
    } else {
        // Authentification échouée
        echo "<script>alert('Email or password incorrect. Please try again.');</script>";
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Patient Portal</title>
    <style>
        /* Styles for the login page */
        body {
            font-family: 'Roboto', sans-serif;
            /* Using Roboto for better readability */
            background: url('images/patient.jpg') no-repeat center center fixed;
            /* Background image */
            background-size: cover;
            /* Cover the entire background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            /* Slight transparency for background */
            padding: 30px 40px;
            /* Padding for the container */
            border-radius: 10px;
            box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            /* Limiting maximum width for better readability on large screens */
        }

        .login-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            /* Space below heading */
        }

        .input-group {
            width: 100%;
            margin-bottom: 15px;
            /* Space between input groups */
        }

        label {
            font-weight: bold;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input[type="text"],
        input[type="password"] {
            padding: 12px;
            /* Increased padding for better touch experience */
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            transition: border-color 0.3s ease-in-out;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .create-account-link {
            margin-top: 10px;
            text-align: center;
            /* Center aligned */
            width: 100%;
        }

        .create-account-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        .create-account-link a:hover {
            color: #45a049;
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
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Responsive design */
        @media only screen and (max-width: 600px) {
            .login-container {
                padding: 20px;
            }

            input[type="text"],
            input[type="password"],
            button {
                padding: 12px;
                /* Adjusted padding */
                font-size: 14px;
                /* Adjusted font size */
            }
        }

        /* Password validator */
        .invalid {
            color: red;
        }

        .valid {
            color: green;
        }
    </style>
    <!-- Using Google font for a professional look -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="login-form">
            <img src="images/logo.png" alt="Hospital Logo" style="width: 100px; margin-bottom: 20px;">
            <h2>Patient Login</h2>
            <div class="input-group">
                <label for="username">Username (Email)</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required onkeyup="validatePassword()">
            </div>
            <button type="submit">Login</button>
            <div class="create-account-link">
                <a href="register.php">Create a new account</a>
                <!-- <div id="message">
                    <h3>Password must contain the following:</h3>
                    <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                    <p id="number" class="invalid">A <b>number</b></p>
                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                </div> -->
                <div id="validationMessages">
                    <h3>Password must contain the following:</h3>
                    <p id="minLength" class="invalid">Minimum 8 characters</p>
                    <p id="hasLowerCase" class="invalid">A lowercase letter</p>
                    <p id="hasUpperCase" class="invalid">A capital (uppercase) letter</p>
                    <p id="hasNumber" class="invalid">A number</p>
                </div>
            </div>
        </form>
    </div>
</body>
<script>
    var myInput = document.getElementById("psw");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    // When the user clicks on the password field, show the message box
    myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
    }

    // When the user clicks outside of the password field, hide the message box
    myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
    }

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }

    function validatePassword() {
        const password = document.getElementById('password').value;

        // Validation checks
        const minLength = password.length >= 8;
        const hasLowerCase = /[a-z]/.test(password);
        const hasUpperCase = /[A-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);

        // Update UI based on validation
        document.getElementById('minLength').className = minLength ? 'valid' : 'invalid';
        document.getElementById('hasLowerCase').className = hasLowerCase ? 'valid' : 'invalid';
        document.getElementById('hasUpperCase').className = hasUpperCase ? 'valid' : 'invalid';
        document.getElementById('hasNumber').className = hasNumber ? 'valid' : 'invalid';
    }
</script>

</html>