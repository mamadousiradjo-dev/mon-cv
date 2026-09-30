<?php

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
$nom = trim($_POST["nom"] ?? "");
$email = trim($_POST["email"] ?? "");
$mot_de_passe = $_POST["password"] ?? "";
$confirmation = $_POST["confirmation"] ?? "";


// Vérifier les champs
if (
    empty($nom) ||
    empty($email) ||
    empty($mot_de_passe) ||
    empty($confirmation)
) {
    die("Veuillez remplir tous les champs.");
}


// Vérifier l'adresse email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Adresse email invalide.");
}


// Vérifier les mots de passe
if ($mot_de_passe !== $confirmation) {
    die("Les mots de passe ne correspondent pas.");
}


// Vérifier la longueur du mot de passe
if (strlen($mot_de_passe) < 6) {
    die("Le mot de passe doit contenir au moins 6 caractères.");
}


// Vérifier si l'email existe déjà
$sql = "SELECT id FROM utilisateurs WHERE email = :email";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "email" => $email
]);

if ($stmt->fetch()) {
    die("Cette adresse email est déjà utilisée.");
}


// Sécuriser le mot de passe
$mot_de_passe_hash = password_hash(
    $mot_de_passe,
    PASSWORD_DEFAULT
);


// Ajouter l'utilisateur dans la base de données
$sql = "INSERT INTO utilisateurs
        (nom, email, mot_de_passe)
        VALUES
        (:nom, :email, :mot_de_passe)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    "nom" => $nom,
    "email" => $email,
    "mot_de_passe" => $mot_de_passe_hash
]);


// Message de réussite
echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";

?>