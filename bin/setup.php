<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require dirname(__DIR__) . '/app/Repository/DbConnection.php';

$pdo = App\Repository\DbConnection::connect();
if ($pdo === null) {
    fwrite(STDERR, "Configure DB_NAME, DB_USER et DB_PASSWORD avant l'initialisation.\n");
    exit(1);
}

$pdo->exec("CREATE TABLE IF NOT EXISTS experiences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    entreprise VARCHAR(255) NOT NULL,
    periode VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$pdo->exec("CREATE TABLE IF NOT EXISTS formations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    diplome VARCHAR(255) NOT NULL,
    etablissement VARCHAR(255) NOT NULL,
    annee VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$pdo->exec("CREATE TABLE IF NOT EXISTS user_profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profile_photo_path VARCHAR(255) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$pdo->exec("CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(80) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Les anciennes bases conservent leurs comptes ; on ajoute seulement le rôle manquant.
$roleColumn = $pdo->query("SHOW COLUMNS FROM utilisateurs LIKE 'role'")->fetch();
if ($roleColumn === false) {
    $pdo->exec("ALTER TABLE utilisateurs ADD COLUMN role ENUM('user', 'admin') NOT NULL DEFAULT 'user'");
}

$pdo->prepare('INSERT IGNORE INTO user_profile (id, profile_photo_path) VALUES (1, ?)')
    ->execute(['images/MAMADOU SIRADJO BALDE.jpeg']);
$pdo->prepare('INSERT IGNORE INTO formations (id, diplome, etablissement, annee) VALUES (1, ?, ?, ?)')
    ->execute(['Brevet Technique 3 (BT3) - Génie Informatique', 'Université Mahatma Gandhi', 'En cours (3ème année)']);
$pdo->prepare('INSERT IGNORE INTO experiences (id, titre, entreprise, periode, description) VALUES (1, ?, ?, ?, ?)')
    ->execute([
        'Projet Web : Portfolio CV Dynamique',
        'Projet Académique / Personnel',
        '2026',
        "Conception et développement d'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS ; l'espace d'administration reste à développer.",
    ]);

// Mettre à jour uniquement la phrase de démonstration des anciennes installations.
$oldDescription = "Conception et développement d'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS ; l'espace d'administration reste à développer.";
$newDescription = "Conception et développement d'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS ; l'espace d'administration permet au propriétaire de gérer sa photo.";
$pdo->prepare('UPDATE experiences SET description = ? WHERE id = 1 AND description = ?')
    ->execute([$newDescription, $oldDescription]);

echo "Tables et données de démonstration prêtes. Aucune donnée effacée.\n";
