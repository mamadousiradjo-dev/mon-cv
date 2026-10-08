<?php
// backend/connexion.php

session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,
]);

require_once __DIR__ . '/db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../pages/connexion.html");
    exit();
}

$email = trim($_POST["email"] ?? "");
$mot_de_passe = $_POST["password"] ?? "";

if (empty($email) || empty($mot_de_passe)) {
    die("Veuillez remplir tous les champs.");
}

// Recherche de l'utilisateur dans la base SQLite
$sql = "SELECT id, nom, email, mot_de_passe FROM utilisateurs WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(["email" => $email]);
$utilisateur = $stmt->fetch();

// Vérification du mot de passe
if ($utilisateur && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
    
    session_regenerate_id(true);

    $_SESSION["user_id"] = $utilisateur["id"];
    $_SESSION["nom"] = $utilisateur["nom"];
    $_SESSION["email"] = $utilisateur["email"];

    // Redirection vers la page d'accueil
    header("Location: ../index.html");
    exit();

} else {
    die("Email ou mot de passe incorrect.");
}
?>