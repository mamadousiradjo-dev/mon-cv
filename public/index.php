<?php
declare(strict_types=1);

// Toutes les pages dynamiques passent par ce point d'entrée MVC.
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $path = dirname(__DIR__) . '/app/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($path)) {
        require $path;
    }
});

use App\Controller\AuthController;
use App\Controller\PageController;
use App\Controller\PhotoController;
use App\Infrastructure\Database;
use App\Infrastructure\Response;
use App\Model\CvModel;
use App\Model\UserModel;

header('X-Content-Type-Options: nosniff');
$database = Database::connect();
$users = $database === null ? null : new UserModel($database);
$pages = new PageController(new CvModel($database), $users);
$auth = new AuthController($users);
$photos = new PhotoController($database, $auth);
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

try {
    switch ($method . ' ' . $path) {
        case 'GET /': $pages->home(); break;
        case 'GET /projets': $pages->projects(); break;
        case 'GET /contact': $pages->contact(); break;
        case 'GET /inscription': $pages->register(); break;
        case 'POST /inscription': $auth->register(); break;
        case 'GET /connexion': $pages->login(); break;
        case 'POST /connexion': $auth->login(); break;
        case 'POST /deconnexion': $auth->logout(); break;
        case 'GET /utilisateurs': $pages->users(); break;
        case 'POST /photo': $photos->upload(); break;
        default:
            if ($method === 'GET' && preg_match('~^/photos/([a-f0-9]{32}\.(?:jpg|png|webp))$~', $path, $match)) {
                PhotoController::show($match[1]);
            }
            Response::error(404, 'Page introuvable.');
    }
} catch (Throwable $exception) {
    error_log('Erreur MVC : ' . $exception->getMessage());
    Response::error(500, 'Le site rencontre un problème temporaire.');
}
