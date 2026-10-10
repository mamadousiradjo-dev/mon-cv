<?php
// backend/setup.php
require_once 'db.php';

try {
    // Re-création des tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS experiences (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titre VARCHAR(255) NOT NULL,
        entreprise VARCHAR(255) NOT NULL,
        periode VARCHAR(100) NOT NULL,
        description TEXT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    $pdo->exec("CREATE TABLE IF NOT EXISTS formations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        diplome VARCHAR(255) NOT NULL,
        etablissement VARCHAR(255) NOT NULL,
        annee VARCHAR(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

    // Vider les anciennes données
    $pdo->exec("TRUNCATE TABLE experiences");
    $pdo->exec("TRUNCATE TABLE formations");

    // Insertion formation sans accent sur E
    $pdo->exec("INSERT INTO formations (diplome, etablissement, annee) VALUES
    ('Brevet Technique 3 (BT3) - Génie Informatique', 'Université Mahatma Gandhi', 'En cours (3ème année)')");

    // Insertion expérience sans accent sur E
    $pdo->exec("INSERT INTO experiences (titre, entreprise, periode, description) VALUES
    ('Projet Web : Portfolio CV Dynamique', 'Projet Académique / Personnel', '2026', 'Conception et développement d\'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS et mise en place d\'un système d\'authentification sécurisé.')");

    echo "<h2>✅ Base de données nettoyée et mise à jour sans accents sur E !</h2>";

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>