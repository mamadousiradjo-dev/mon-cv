<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\UserModel;
use App\Repository\UserRepository;
use InvalidArgumentException;
use PDOException;

final class AuthController
{
    public function __construct(private readonly ?UserRepository $users) {}

    public function register(): never
    {
        AuthSession::verify();
        $this->requireDatabase();
        try {
            $id = $this->users->register(
                self::field('name'), self::field('email'),
                self::field('password'), self::field('confirmation'),
            );
        } catch (InvalidArgumentException $exception) {
            $this->reject('/inscription', $exception->getMessage());
        } catch (PDOException $exception) {
            if ($exception->getCode() !== '23000') {
                throw $exception;
            }
            $this->reject('/inscription', 'Cet e-mail est déjà utilisé.');
        }
        AuthSession::login($id);
        Response::redirect('/');
    }

    public function login(): never
    {
        AuthSession::verify();
        $this->requireDatabase();
        $user = $this->users->authenticate(self::field('email'), self::field('password'));
        if ($user === null) {
            $this->reject('/connexion', 'Identifiants invalides.');
        }
        AuthSession::login($user->id);
        Response::redirect('/');
    }

    public function logout(): never
    {
        AuthSession::verify();
        AuthSession::logout();
        Response::redirect('/');
    }

    public function requireOwner(): UserModel
    {
        $id = AuthSession::userId();
        $user = $id === null || $this->users === null ? null : $this->users->byId($id);
        if ($user === null || !$user->isOwner()) {
            Response::error(403, 'Accès réservé au propriétaire.');
        }
        return $user;
    }

    private static function field(string $key): string
    {
        $value = $_POST[$key] ?? null;
        return is_string($value) ? $value : '';
    }

    private function requireDatabase(): void
    {
        if ($this->users === null) {
            Response::error(503, 'Base de données indisponible.');
        }
    }

    private function reject(string $path, string $message): never
    {
        AuthSession::flash($message);
        Response::redirect($path);
    }
}
