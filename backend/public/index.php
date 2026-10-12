<?php
declare(strict_types=1);

// Point d'entrée HTTP : aucun fichier de src/ ou bin/ n'est exposé au web.
require dirname(__DIR__) . '/src/Infrastructure/Database.php';
require dirname(__DIR__) . '/src/Model/CvModel.php';
require dirname(__DIR__) . '/src/Controller/CvController.php';

use App\Controller\CvController;
use App\Infrastructure\Database;
use App\Model\CvModel;

$allowedOrigin = getenv('FRONTEND_ORIGIN') ?: 'http://127.0.0.1:8000';
if (($_SERVER['HTTP_ORIGIN'] ?? '') === $allowedOrigin) {
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
    header('Vary: Origin');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    http_response_code(405);
    header('Allow: GET');
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if ($path === '/api/cv') {
    (new CvController(new CvModel(Database::connect())))->show();
    exit;
}

if ($path === '/api/health') {
    header('Content-Type: application/json; charset=utf-8');
    echo '{"status":"ok"}';
    exit;
}

http_response_code(404);
header('Content-Type: application/json; charset=utf-8');
echo '{"error":"Route introuvable"}';
