<?php

// Démarrer la session
session_start();


// Connexion à la base de données
$host = "localhost";
$dbname = "mon_cv";
$username = "root";
$password = "Mamadou@2026";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion à MySQL : " . $e->getMessage());
}


// Vérifier que le formulaire a été envoyé
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Accès interdit.");
}


// Récupérer les données du formulaire
$email = trim($_POST["email"] ?? "");
$mot_de_passe = $_POST["password"] ?? "";


// Vérifier les champs
if (empty($email) || empty($mot_de_passe)) {
    die("Veuillez remplir tous les champs.");
}


// Vérifier l'adresse email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Adresse email invalide.");
}


// Rechercher l'utilisateur
$sql = "SELECT id, nom, email, mot_de_passe
        FROM utilisateurs
        WHERE email = :email";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "email" => $email
]);

$utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);


// Vérifier l'utilisateur et le mot de passe
if (
    $utilisateur &&
    password_verify(
        $mot_de_passe,
        $utilisateur["mot_de_passe"]
    )
) {

    // Enregistrer les informations dans la session
    $_SESSION["user_id"] = $utilisateur["id"];
    $_SESSION["nom"] = $utilisateur["nom"];
    $_SESSION["email"] = $utilisateur["email"];


    echo "Connexion réussie ! Bienvenue "
        . htmlspecialchars($utilisateur["nom"]);

} else {

    echo "Email ou mot de passe incorrect.";

}

?>