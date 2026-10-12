<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\Api;
use App\Infrastructure\AuthSession;
use App\Model\UserModel;
use PDOException;

final class AuthController
{
    public function __construct(private readonly UserModel $users) {}

    public function session(): never
    {
        $id = AuthSession::userId();
        $user = $id === null ? null : $this->users->byId($id);
        if ($id !== null && $user === false) AuthSession::logout();
        Api::json(['user' => $user ?: null, 'csrf' => AuthSession::token()]);
    }

    public function register(): never
    {
        AuthSession::verify();
        $body = Api::body();
        if (!is_string($body['name'] ?? null) || !is_string($body['email'] ?? null)) {
            Api::json(['error' => 'Nom et e-mail invalides.'], 422);
        }
        $name = trim($body['name']);
        $email = strtolower(trim($body['email']));
        $password = $body['password'] ?? null;
        if (mb_strlen($name) < 2 || mb_strlen($name) > 80 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190 || !is_string($password) || strlen($password) < 12 || strlen($password) > 1024) {
            Api::json(['error' => 'Nom (2 à 80 caractères), e-mail valide et mot de passe (12 caractères minimum) requis.'], 422);
        }
        try {
            $id = $this->users->create($name, $email, $password);
        } catch (PDOException $exception) {
            if ($exception->getCode() === '23000') Api::json(['error' => 'Cet e-mail est déjà utilisé.'], 409);
            throw $exception;
        }
        AuthSession::login($id);
        Api::json(['user' => $this->users->byId($id), 'csrf' => AuthSession::token()], 201);
    }

    public function login(): never
    {
        AuthSession::verify();
        $body = Api::body();
        if (!is_string($body['email'] ?? null)) Api::json(['error' => 'Identifiants invalides.'], 401);
        $email = strtolower(trim($body['email']));
        $password = $body['password'] ?? null;
        if (strlen($email) > 190 || !is_string($password) || strlen($password) > 1024) Api::json(['error' => 'Identifiants invalides.'], 401);
        $user = $this->users->byEmail($email);
        if ($user === false || !password_verify($password, $user['mot_de_passe'])) {
            Api::json(['error' => 'Identifiants invalides.'], 401);
        }
        AuthSession::login((int) $user['id']);
        Api::json(['user' => $this->users->byId((int) $user['id']), 'csrf' => AuthSession::token()]);
    }

    public function logout(): never
    {
        AuthSession::verify();
        AuthSession::logout();
        Api::json(['user' => null, 'csrf' => AuthSession::token()]);
    }

    public function requireOwner(): array
    {
        $id = AuthSession::userId();
        $user = $id === null ? false : $this->users->byId($id);
        if ($user === false || $user['role'] !== 'admin') Api::json(['error' => 'Accès réservé au propriétaire.'], 403);
        return $user;
    }

    public function users(): never
    {
        $this->requireOwner();
        Api::json(['users' => $this->users->all()]);
    }
}
