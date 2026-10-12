<?php
declare(strict_types=1);

// Promotion manuelle : ne jamais donner le rôle admin depuis un formulaire public.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__) . '/src/Infrastructure/Database.php';
$email = strtolower(trim($argv[1] ?? ''));
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "Usage : php backend/bin/promote_admin.php adresse@email\n");
    exit(1);
}
$pdo = App\Infrastructure\Database::connect();
if ($pdo === null) { fwrite(STDERR, "Base de données indisponible.\n"); exit(1); }
$query = $pdo->prepare("UPDATE utilisateurs SET role = 'admin' WHERE email = ?");
$query->execute([$email]);
if ($query->rowCount() !== 1) { fwrite(STDERR, "Aucun compte à promouvoir (ou déjà administrateur).\n"); exit(1); }
echo "Compte propriétaire activé pour $email.\n";
