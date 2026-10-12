<?php
declare(strict_types=1);

namespace App\Model;

final class Book
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $author,
        public readonly bool $borrowed,
    ) {}

    /** Vérifier les champs d'un nouveau livre ; lever InvalidArgumentException si nécessaire. */
    public function validate(): void
    {
        // TODO élève : titre et auteur non vides, avec une longueur raisonnable.
        throw new \LogicException('Validation du livre à implémenter.');
    }

    /** Un livre ne peut être emprunté que s'il est disponible. */
    public function canBorrow(): bool
    {
        // TODO élève : retourner la bonne valeur selon $borrowed.
        throw new \LogicException('Règle d’emprunt à implémenter.');
    }
}
