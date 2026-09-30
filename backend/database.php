<?php

$host = "localhost";
$dbname = "mon_cv";
$username = "root";
$password = "";

try {
    $connexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connexion à MySQL réussie !";

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>