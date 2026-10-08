<?php
// backend/setup.php

$host = "localhost";
$username = "root";
$password = "Mysql7474@"; // Inscrivez votre mot de passe exact ici

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS mon_cv CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
    $pdo->exec("USE mon_cv;");

    $sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(255) NOT NULL,
        date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);

    echo "<h1 style='color: green; text-align: center; font-family: sans-serif; margin-top: 50px;'>✅ BASE DE DONNÉES ET TABLE CRÉÉES AVEC SUCCÈS !</h1>";

} catch (PDOException $e) {
    echo "<h2 style='color: red; font-family: sans-serif;'>❌ Erreur SQL : " . $e->getMessage() . "</h2>";
}
?>