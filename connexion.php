<?php

// Fonction pour se connecter à la base de données
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pfe_william";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

// Appeler cette fonction pour se connecter à la base de données
$conn = connectDB();

?>
