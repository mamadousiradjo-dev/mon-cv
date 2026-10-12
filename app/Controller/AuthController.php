<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\AuthSession;
use App\Infrastructure\Response;
use App\Model\UserModel;
use PDOException;

final class AuthController
{
    public function __construct(private readonly ?UserModel $users) {}

    public function register(): never
    {
        AuthSession::verify();
        $this->requireDatabase();

        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $confirmation = $_POST['confirmation'] ?? null;
        if (!is_string($name) || !is_string($email) || !is_string($password) || !is_string($confirmation)) {
            $this->reject('/inscription', 'Formulaire invalide.');
        }
        $name = trim($name);
        $email = strtolower(trim($email));
        if (mb_strlen($name) < 2 || mb_strlen($name) > 80 ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190 ||
            strlen($password) < 12 || strlen($password) > 1024 || $password !== $confirmation) {
            $this->reject('/inscription', 'Vérifiez le nom, l’e-mail et les mots de passe (12 caractères minimum).');
        }

        try {
            $id = $this->users->create($name, $email, $password);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') {
                $this->reject('/inscription', 'Cet e-mail est déjà utilisé.');
            }
            throw $exception;
        }
        AuthSession::login($id);
        Response::redirect('/');
    }

    public function login(): never
    {
        AuthSession::verify();
        $this->requireDatabase();

        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        if (!is_string($email) || !is_string($password) || strlen($email) > 190 || strlen($password) > 1024) {
            $this->reject('/connexion', 'Identifiants invalides.');
        }
        $user = $this->users->byEmail(strtolower(trim($email)));
        if ($user === false || !password_verify($password, $user['mot_de_passe'])) {
            $this->reject('/connexion', 'Identifiants invalides.');
        }
        AuthSession::login((int) $user['id']);
        Response::redirect('/');
    }

    public function logout(): never
    {
        AuthSession::verify();
        AuthSession::logout();
        Response::redirect('/');
    }

    public function requireOwner(): array
    {
        $id = AuthSession::userId();
        $user = $id === null || $this->users === null ? false : $this->users->byId($id);
        if ($user === false || $user['role'] !== 'admin') {
            Response::error(403, 'Accès réservé au propriétaire.');
        }
        return $user;
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
