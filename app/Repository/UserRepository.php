<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\UserModel;
use PDO;

// Les requêtes SQL et les hachages restent ici, loin des vues.
final class UserRepository
{
    public function __construct(private readonly PDO $database) {}

    public function create(string $name, string $email, string $password): int
    {
        $query = $this->database->prepare('INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)');
        $query->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        return (int) $this->database->lastInsertId();
    }

    public function authenticate(string $email, string $password): ?UserModel
    {
        $query = $this->database->prepare('SELECT id, nom, email, mot_de_passe, role FROM utilisateurs WHERE email = ? LIMIT 1');
        $query->execute([$email]);
        $row = $query->fetch();
        if ($row === false || !password_verify($password, $row['mot_de_passe'])) {
            return null;
        }
        return self::toModel($row);
    }

    public function byId(int $id): ?UserModel
    {
        $query = $this->database->prepare('SELECT id, nom, email, role FROM utilisateurs WHERE id = ? LIMIT 1');
        $query->execute([$id]);
        $row = $query->fetch();
        return $row === false ? null : self::toModel($row);
    }

    /** @return UserModel[] */
    public function all(): array
    {
        $rows = $this->database->query('SELECT id, nom, email, role FROM utilisateurs ORDER BY id DESC')->fetchAll();
        return array_map(self::toModel(...), $rows);
    }

    private static function toModel(array $row): UserModel
    {
        return new UserModel((int) $row['id'], $row['nom'], $row['email'], $row['role']);
    }
}
