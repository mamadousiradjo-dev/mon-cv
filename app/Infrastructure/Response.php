<?php
declare(strict_types=1);

namespace App\Infrastructure;

final class Response
{
    public static function redirect(string $path): never
    {
        header('Location: ' . $path, true, 303);
        exit;
    }

    public static function error(int $status, string $message): never
    {
        http_response_code($status);
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html lang="fr"><meta charset="UTF-8"><title>Erreur</title>';
        echo '<body><h1>Erreur ' . $status . '</h1><p>' . View::e($message) . '</p>';
        echo '<p><a href="/">Retour à l’accueil</a></p></body></html>';
        exit;
    }
}
