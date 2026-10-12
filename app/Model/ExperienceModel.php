<?php
declare(strict_types=1);

namespace App\Model;

final class ExperienceModel
{
    public function __construct(
        public readonly string $title,
        public readonly string $company,
        public readonly string $period,
        public readonly string $description,
    ) {}

    public function validate(): void
    {
        // TODO élève : vérifier les champs obligatoires et leurs longueurs.
        // Lever InvalidArgumentException avec un message compréhensible si nécessaire.
        throw new \LogicException('Exercice : valider une expérience.');
    }
}
