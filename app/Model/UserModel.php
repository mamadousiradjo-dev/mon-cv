<?php
declare(strict_types=1);

namespace App\Model;

use PDO;

final class UserModel
{
    public function __construct(private readonly PDO $database) {}

    public function create(string $name, string $email, string $password): int
    {
        $query = $this->database->prepare('INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)');
        $query->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        return (int) $this->database->lastInsertId();
    }

    public function byEmail(string $email): array|false
    {
        $query = $this->database->prepare('SELECT id, nom, email, mot_de_passe, role FROM utilisateurs WHERE email = ? LIMIT 1');
        $query->execute([$email]);
        return $query->fetch();
    }

    public function byId(int $id): array|false
    {
        $query = $this->database->prepare('SELECT id, nom, email, role FROM utilisateurs WHERE id = ? LIMIT 1');
        $query->execute([$id]);
        return $query->fetch();
    }

    public function all(): array
    {
        return $this->database->query('SELECT id, nom, email, role FROM utilisateurs ORDER BY id DESC')->fetchAll();
    }
}
