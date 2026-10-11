<?php
// backend/db.php

$host = 'localhost';
$db   = 'mon_cv';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$pdo = null;

try {
    // Vérification de la présence du driver pdo_mysql
    if (in_array('mysql', PDO::getAvailableDrivers())) {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $options);
    }
} catch (Exception $e) {
    // En cas d'erreur de connexion, on laisse $pdo à null sans interrompre le site
    $pdo = null;
}