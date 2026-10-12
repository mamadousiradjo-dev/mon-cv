<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

require __DIR__ . '/db.php';

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

// Réexécuter ce script conserve les données existantes.
$stmt = $pdo->prepare('INSERT IGNORE INTO user_profile (id, profile_photo_path) VALUES (1, :photo)');
$stmt->execute(['photo' => 'images/MAMADOU SIRADJO BALDE.jpeg']);

echo "Tables créées ou déjà présentes. Aucune donnée effacée.\n";
