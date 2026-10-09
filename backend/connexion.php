<?php
// backend/connexion.php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if (empty($email) || empty($mot_de_passe)) {
        die("Veuillez remplir tous les champs.");
    }

    try {
        // 1. Requête préparée pour récupérer l'utilisateur par son email
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        // 2. Vérification de l'existence de l'utilisateur et du mot de passe
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Création de la session utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];

            echo "<h2>🎉 Connexion réussie ! Bienvenue " . htmlspecialchars($user['nom']) . "</h2>";
            echo "<p><a href='voir_utilisateurs.php'>Voir la liste des utilisateurs</a></p>";
        } else {
            echo "<h2>❌ Email ou mot de passe incorrect.</h2>";
            echo "<p><a href='../pages/connexion.html'>Réessayer</a></p>";
        }

    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}
?>