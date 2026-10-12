<?php
declare(strict_types=1);

namespace App\View;

final class View
{
    public static function render(string $name, array $data = []): void
    {
        // Le contrôleur choisit une vue connue ; le navigateur ne fournit jamais ce nom.
        extract($data, EXTR_SKIP);
        require __DIR__ . '/' . $name . '.php';
    }

    public static function e(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function photoUrl(string $path): string
    {
        if (preg_match('~^uploads/([a-f0-9]{32}\.(?:jpg|png|webp))$~', $path, $match)) {
            return '/uploads/' . $match[1];
        }
        if (str_starts_with($path, 'images/') && !str_contains($path, '..')) {
            return '/' . implode('/', array_map('rawurlencode', explode('/', $path)));
        }
        return '/images/MAMADOU%20SIRADJO%20BALDE.jpeg';
    }
}
