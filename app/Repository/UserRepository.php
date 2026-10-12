<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\UserModel;
use PDO;

final class UserRepository
{
    public function __construct(private readonly PDO $database) {}

    public function register(string $name, string $email, string $password, string $confirmation): int
    {
        $name = trim($name);
        $email = strtolower(trim($email));
        if (mb_strlen($name) < 2 || mb_strlen($name) > 80 ||
            !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190 ||
            strlen($password) < 12 || strlen($password) > 1024 || $password !== $confirmation) {
            throw new \InvalidArgumentException('Vérifiez le nom, l’e-mail et les mots de passe (12 caractères minimum).');
        }

        $query = $this->database->prepare('INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)');
        $query->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
        return (int) $this->database->lastInsertId();
    }

    public function authenticate(string $email, string $password): ?UserModel
    {
        if (strlen($email) > 190 || strlen($password) > 1024) {
            return null;
        }
        $query = $this->database->prepare('SELECT id, nom, email, mot_de_passe, role FROM utilisateurs WHERE email = ? LIMIT 1');
        $query->execute([strtolower(trim($email))]);
        $row = $query->fetch();
        return $row !== false && password_verify($password, $row['mot_de_passe'])
            ? self::toModel($row)
            : null;
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
