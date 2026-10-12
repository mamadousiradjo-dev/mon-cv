<?php
declare(strict_types=1);

namespace App\Controller;

use App\View\View;

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
        View::render('pages/error', ['status' => $status, 'message' => $message]);
        exit;
    }
}
