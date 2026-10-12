<?php
declare(strict_types=1);

// Seul ce fichier est servi par le serveur HTTP ; src/, bin/ et storage/ restent privés.
require dirname(__DIR__) . '/src/Infrastructure/Database.php';
require dirname(__DIR__) . '/src/Infrastructure/Api.php';
require dirname(__DIR__) . '/src/Infrastructure/AuthSession.php';
require dirname(__DIR__) . '/src/Model/CvModel.php';
require dirname(__DIR__) . '/src/Model/UserModel.php';
require dirname(__DIR__) . '/src/Controller/CvController.php';
require dirname(__DIR__) . '/src/Controller/AuthController.php';
require dirname(__DIR__) . '/src/Controller/PhotoController.php';

use App\Controller\AuthController;
use App\Controller\CvController;
use App\Controller\PhotoController;
use App\Infrastructure\Api;
use App\Infrastructure\Database;
use App\Model\CvModel;
use App\Model\UserModel;

$allowedOrigin = getenv('FRONTEND_ORIGIN') ?: 'http://127.0.0.1:8000';
if (($_SERVER['HTTP_ORIGIN'] ?? '') === $allowedOrigin) {
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
    header('Access-Control-Allow-Credentials: true');
}
header('Vary: Origin');
header('X-Content-Type-Options: nosniff');
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');
    http_response_code(204);
    exit;
}
if ($method === 'GET' && $path === '/api/health') Api::json(['status' => 'ok']);
if ($method === 'GET' && $path === '/api/cv') {
    (new CvController(new CvModel(Database::connect())))->show();
    exit;
}
if ($method === 'GET' && preg_match('~^/api/photos/([a-f0-9]{32}\.(?:jpg|png|webp))$~', $path, $matches)) {
    PhotoController::show($matches[1]);
}
$routes = [
    'GET /api/session' => 'session',
    'GET /api/users' => 'users',
    'POST /api/register' => 'register',
    'POST /api/login' => 'login',
    'POST /api/logout' => 'logout',
    'POST /api/photo' => 'photo',
];
$key = $method . ' ' . $path;
if (!isset($routes[$key])) Api::json(['error' => 'Route introuvable.'], 404);
$database = Database::connect();
if ($database === null) Api::json(['error' => 'Base de données indisponible.'], 503);
$auth = new AuthController(new UserModel($database));
if ($routes[$key] === 'photo') (new PhotoController($database, $auth))->upload();
$auth->{$routes[$key]}();
