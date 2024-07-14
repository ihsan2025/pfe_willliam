<?php

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['name'];
    $first_name = $_POST['first_name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Convertir le mot de passe en MD5
    $sex = $_POST['sex'];

    // Inclure le fichier de connexion à la base de données
    require_once('connexion.php');

    // Création de la table "patient" si elle n'existe pas déjà
    $sql_create_table = "CREATE TABLE IF NOT EXISTS patient (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        first_name VARCHAR(100) NOT NULL,
        address VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(32) NOT NULL, -- MD5 hash is 32 characters long
        sex ENUM('female', 'male') NOT NULL
    )";

    if ($conn->query($sql_create_table) === TRUE) {
        // Table créée avec succès (pas besoin d'afficher un message ici)
    } else {
        echo "Error creating table: " . $conn->error . "<br>";
    }

    // Préparer la requête d'insertion avec une requête préparée pour éviter les injections SQL
    $sql_insert = "INSERT INTO patient (name, first_name, address, email, password, sex)
                   VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssssss", $name, $first_name, $address, $email, $password, $sex);

    // Exécuter la requête d'insertion
    if ($stmt->execute()) {
        // Message de succès
        $message = "Account created successfully.";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error . "<br>";
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
    <title>Patient Registration</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('images/register1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container img {
            display: block;
            margin: 0 auto 20px;
            width: 100px;
            height: auto;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            width: 100%;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            border-color: #28a745;
            box-shadow: 0 0 8px rgba(40, 167, 69, 0.2);
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            margin-top: 20px;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        .footer a {
            color: #28a745;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // JavaScript for success dialog box after data insertion
        window.onload = function() {
            <?php if (!empty($message)): ?>
                alert("<?php echo $message; ?>");
            <?php endif; ?>
        }
    </script>
</head>
<body>
    <div class="container">
        <img src="images/logo.png" alt="Hospital Logo">
        <h2>Create an account</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <input type="text" id="name" name="name" placeholder="Your Name" required>
            </div>
            <div class="form-group">
                <input type="text" id="first_name" name="first_name" placeholder="Your First Name" required>
            </div>
            <div class="form-group">
                <input type="text" id="address" name="address" placeholder="Your Address" required>
            </div>
            <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Your Email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="sex">Sex:</label>
                <select id="sex" name="sex" required>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
            </div>
            <button type="submit">REGISTER</button>
        </form>
        <div class="footer">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
