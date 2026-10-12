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
use App\Controller\Response;
use App\Repository\DbConnection;
use App\Repository\CvRepository;
use App\Repository\UserRepository;

header('X-Content-Type-Options: nosniff');
$database = DbConnection::connect();
$users = $database === null ? null : new UserRepository($database);
$cv = new CvRepository($database);
$pages = new PageController($cv, $users);
$auth = new AuthController($users);
$photos = new PhotoController($cv, $auth);
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
            Response::error(404, 'Page introuvable.');
    }
} catch (Throwable $exception) {
    error_log('Erreur MVC : ' . $exception->getMessage());
    Response::error(500, 'Le site rencontre un problème temporaire.');
}
