<?php
declare(strict_types=1);

namespace App\Model;

// Un modèle contient les données du CV, sans SQL ni HTML.
final class CvModel
{
    public function __construct(
        public readonly string $photo,
        public readonly array $formation,
        public readonly array $experience,
    ) {}
}
