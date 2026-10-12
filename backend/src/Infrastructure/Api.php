<?php
declare(strict_types=1);

namespace App\Infrastructure;

final class Api
{
    public static function json(array $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        exit;
    }

    public static function body(): array
    {
        if ((int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 16384) {
            self::json(['error' => 'Requête trop volumineuse.'], 413);
        }
        if (!str_starts_with(strtolower($_SERVER['CONTENT_TYPE'] ?? ''), 'application/json')) {
            self::json(['error' => 'Format JSON attendu.'], 415);
        }
        $body = json_decode(file_get_contents('php://input'), true);
        if (!is_array($body) || array_is_list($body)) {
            self::json(['error' => 'JSON invalide.'], 400);
        }
        return $body;
    }
}
