<?php
// backend/setup.php
require_once 'db.php';

try {
    // 1. Table Utilisateurs
    $pdo->exec("CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        mot_de_passe VARCHAR(255) NOT NULL,
        cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Table Expériences
    $pdo->exec("CREATE TABLE IF NOT EXISTS experiences (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        entreprise VARCHAR(255) NOT NULL,
        periode VARCHAR(100) NOT NULL,
        description TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Table Formations / Diplômes
    $pdo->exec("CREATE TABLE IF NOT EXISTS formations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        diplome VARCHAR(255) NOT NULL,
        etablissement VARCHAR(255) NOT NULL,
        annee VARCHAR(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Insertion d'expériences de test si la table est vide
    $checkExp = $pdo->query("SELECT COUNT(*) FROM experiences")->fetchColumn();
    if ($checkExp == 0) {
        $pdo->exec("INSERT INTO experiences (titre, entreprise, periode, description) VALUES
        ('Développeur Web Débutant', 'Projet Personnel', '2026', 'Création d\'un site CV dynamique avec PHP, MySQL et Tailwind CSS.'),
        ('Stagiaire Informatique', 'Entreprise Tech', '2025 - 2026', 'Maintenance informatique et assistance technique.')");
    }

    // Insertion de formations de test si la table est vide
    $checkForm = $pdo->query("SELECT COUNT(*) FROM formations")->fetchColumn();
    if ($checkForm == 0) {
        $pdo->exec("INSERT INTO formations (diplome, etablissement, annee) VALUES
        ('Licence / BTS en Informatique', 'Université / École', '2024 - 2026'),
        ('Baccalauréat Scientifique', 'Lycée', '2024')");
    }

    echo "<h2>✅ Base de données installée avec succès avec les tables du CV !</h2>";

} catch (PDOException $e) {
    echo "Erreur lors de la configuration : " . $e->getMessage();
}
?>