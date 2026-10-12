<?php
declare(strict_types=1);

namespace App\Infrastructure;

final class AuthSession
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        session_name('MONCVSESSID');
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    public static function token(): string
    {
        self::start();
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function verify(): void
    {
        $given = $_POST['csrf'] ?? null;
        if (!is_string($given) || !hash_equals(self::token(), $given)) {
            Response::error(403, 'Formulaire expiré. Rechargez la page et réessayez.');
        }
    }

    public static function userId(): ?int
    {
        self::start();
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }

    public static function login(int $id): void
    {
        self::start();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    public static function logout(): void
    {
        self::start();
        $_SESSION = [];
        session_regenerate_id(true);
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }

    public static function flash(string $message): void
    {
        self::start();
        $_SESSION['flash'] = $message;
    }

    public static function takeFlash(): ?string
    {
        self::start();
        $message = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return is_string($message) ? $message : null;
    }
}
