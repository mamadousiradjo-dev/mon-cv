<?php
// backend/inscription.php

// Démarrer la session
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
    'use_strict_mode' => true,
]);

// Inclure la connexion à la base de données
require_once __DIR__ . '/db.php';

// Vérifier que le formulaire a bien été envoyé en POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../pages/inscription.html");
    exit();
}

// Récupérer et nettoyer les données du formulaire
$nom = trim(strip_tags($_POST["nom"] ?? ""));
$email = trim($_POST["email"] ?? "");
$mot_de_passe = $_POST["password"] ?? "";
$confirmation = $_POST["confirmation"] ?? "";

// 1. Vérifier que tous les champs sont remplis
if (empty($nom) || empty($email) || empty($mot_de_passe) || empty($confirmation)) {
    die("Veuillez remplir tous les champs.");
}

// 2. Vérifier le format de l'adresse email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Adresse email invalide.");
}

// 3. Vérifier que les mots de passe correspondent
if ($mot_de_passe !== $confirmation) {
    die("Les mots de passe ne correspondent pas.");
}

// 4. Vérifier la longueur minimale du mot de passe
if (mb_strlen($mot_de_passe) < 6) {
    die("Le mot de passe doit contenir au moins 6 caractères.");
}

// 5. Vérifier si l'adresse email existe déjà dans la base
$sql = "SELECT id FROM utilisateurs WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(["email" => $email]);

if ($stmt->fetch()) {
    die("Cette adresse email est déjà utilisée.");
}

// 6. Hacher le mot de passe de manière sécurisée
$mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

// 7. Insérer le nouvel utilisateur dans la base de données
$sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([
    "nom" => $nom,
    "email" => $email,
    "mot_de_passe" => $mot_de_passe_hash
])) {
    // Redirection vers la page de connexion après inscription réussie
    header("Location: ../pages/connexion.html?inscription=succes");
    exit();
} else {
    die("Une erreur est survenue lors de l'inscription.");
}
?>