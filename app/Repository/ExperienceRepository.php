<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\ExperienceModel;
use PDO;

final class ExperienceRepository
{
    public function __construct(private readonly PDO $database) {}

    public function create(ExperienceModel $experience): int
    {
        // TODO élève : INSERT préparé dans experiences, puis retourner lastInsertId().
        throw new \LogicException('Exercice : enregistrer une expérience.');
    }

    /** @return ExperienceModel[] */
    public function all(): array
    {
        // TODO élève : SELECT de toutes les expériences et conversion en modèles.
        throw new \LogicException('Exercice : lire les expériences.');
    }
}
