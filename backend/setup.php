<?php
// backend/setup.php
require_once 'db.php';

try {
    // 1. Table experiences
    $pdo->exec("CREATE TABLE IF NOT EXISTS experiences (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        entreprise VARCHAR(255) NOT NULL,
        periode VARCHAR(100) NOT NULL,
        description TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 2. Table formations
    $pdo->exec("CREATE TABLE IF NOT EXISTS formations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        diplome VARCHAR(255) NOT NULL,
        etablissement VARCHAR(255) NOT NULL,
        annee VARCHAR(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // 3. Table user_profile (demandée par le professeur)
    $pdo->exec("CREATE TABLE IF NOT EXISTS user_profile (
        id INT AUTO_INCREMENT PRIMARY KEY,
        profile_photo_path VARCHAR(255) NOT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Réinitialisation des données
    $pdo->exec("TRUNCATE TABLE experiences");
    $pdo->exec("TRUNCATE TABLE formations");
    $pdo->exec("TRUNCATE TABLE user_profile");

    // Données formations & expériences
    $pdo->exec("INSERT INTO formations (diplome, etablissement, annee) VALUES
    ('Brevet Technique 3 (BT3) - Génie Informatique', 'Université Mahatma Gandhi', 'En cours (3ème année)')");

    $pdo->exec("INSERT INTO experiences (titre, entreprise, periode, description) VALUES
    ('Projet Web : Portfolio CV Dynamique', 'Projet Académique / Personnel', '2026', 'Conception et développement d\'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS et mise en place d\'un système d\'authentification sécurisé.')");

    // Image de profil par défaut
    $pdo->exec("INSERT INTO user_profile (profile_photo_path) VALUES ('images/MAMADOU SIRADJO BALDE.jpeg')");

    echo "<h2>✅ Base de données mise à jour avec succès pour l'Issue #1 !</h2>";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>