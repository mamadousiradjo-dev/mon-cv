<?php
declare(strict_types=1);

namespace App\Model;

// Le modèle représente le CV, indépendamment de MySQL et du HTML.
final class CvModel
{
    public function __construct(
        public readonly string $photo,
        public readonly array $formation,
        public readonly array $experience,
    ) {}

    public static function defaults(): self
    {
        return new self(
            'images/MAMADOU SIRADJO BALDE.jpeg',
            [
                'diplome' => 'Brevet Technique 3 (BT3) - Génie Informatique',
                'etablissement' => 'Université Mahatma Gandhi',
                'annee' => 'En cours (3ème année)',
            ],
            [
                'titre' => 'Projet Web : Portfolio CV Dynamique',
                'entreprise' => 'Projet Académique / Personnel',
                'periode' => '2026',
                'description' => "Conception et développement d'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS ; l'espace d'administration permet au propriétaire de gérer sa photo.",
            ],
        );
    }
}
