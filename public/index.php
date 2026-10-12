<?php
declare(strict_types=1);

require dirname(__DIR__) . '/app/Model/Book.php';
require dirname(__DIR__) . '/app/Repository/BookRepository.php';
require dirname(__DIR__) . '/app/Controller/BookController.php';

use App\Controller\BookController;
use App\Repository\BookRepository;

// Le serveur PHP sert directement le CSS compilé.
if (parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) === '/output.css') {
    return false;
}

$database = new PDO('sqlite:' . dirname(__DIR__) . '/data/books.sqlite');
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$controller = new BookController(new BookRepository($database));

// Une route associe une méthode HTTP et un chemin à une action du contrôleur.
$routes = [
    'GET /' => [$controller, 'index'],
    // TODO élève : brancher les routes pour form(), create(), borrow() et returnBook().
];

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$route = $method . ' ' . $path;

if (!isset($routes[$route])) {
    http_response_code(404);
    echo 'Page introuvable.';
    exit;
}

$routes[$route]();
