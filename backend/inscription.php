<?php
// backend/inscription.php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        die("Veuillez remplir tous les champs.");
    }

    try {
        // 1. Requête préparée pour vérifier si l'email existe déjà
        $stmt_check = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = :email");
        $stmt_check->execute(['email' => $email]);

        if ($stmt_check->fetch()) {
            die("Cet email est déjà utilisé par un autre compte.");
        }

        // 2. Hachage sécurisé du mot de passe
        $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // 3. Requête préparée pour insérer le nouvel utilisateur
        $stmt_insert = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (:nom, :email, :mot_de_passe)");
        $stmt_insert->execute([
            'nom' => $nom,
            'email' => $email,
            'mot_de_passe' => $hash
        ]);

        echo "<h2>✅ Inscription réussie !</h2>";
        echo "<p><a href='../pages/connexion.html'>Cliquer ici pour vous connecter</a></p>";

    } catch (PDOException $e) {
        echo "Erreur lors de l'inscription : " . $e->getMessage();
    }
}
?>