<?php
declare(strict_types=1);

namespace App\Model;

// Les mots de passe ne font pas partie du modèle transmis aux vues.
final class UserModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $role,
    ) {}

    public function isOwner(): bool
    {
        return $this->role === 'admin';
    }
}
