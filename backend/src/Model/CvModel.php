<?php
declare(strict_types=1);

namespace App\Model;

use PDO;
use PDOException;

final class CvModel
{
    public function __construct(private readonly ?PDO $database)
    {
    }

    public function getCv(): array
    {
        $cv = [
            'photo' => 'images/MAMADOU SIRADJO BALDE.jpeg',
            'formation' => [
                'diplome' => 'Brevet Technique 3 (BT3) - Génie Informatique',
                'etablissement' => 'Université Mahatma Gandhi',
                'annee' => 'En cours (3ème année)',
            ],
            'experience' => [
                'titre' => 'Projet Web : Portfolio CV Dynamique',
                'entreprise' => 'Projet Académique / Personnel',
                'periode' => '2026',
                'description' => "Conception et développement d'un site CV dynamique avec PHP, MySQL (PDO), Tailwind CSS ; l'espace d'administration permet au propriétaire de gérer sa photo.",
            ],
        ];

        if ($this->database === null) {
            return $cv;
        }

        try {
            $photo = $this->database->query('SELECT profile_photo_path FROM user_profile WHERE id = 1 LIMIT 1')->fetchColumn();
            if (is_string($photo) && ((str_starts_with($photo, 'images/') && !str_contains($photo, '..')) || preg_match('~^uploads/[a-f0-9]{32}\.(?:jpg|png|webp)$~', $photo))) {
                $cv['photo'] = $photo;
            }

            $formation = $this->database->query('SELECT diplome, etablissement, annee FROM formations ORDER BY id LIMIT 1')->fetch();
            if ($formation !== false) {
                $cv['formation'] = $formation;
            }

            $experience = $this->database->query('SELECT titre, entreprise, periode, description FROM experiences ORDER BY id LIMIT 1')->fetch();
            if ($experience !== false) {
                $cv['experience'] = $experience;
            }
        } catch (PDOException $exception) {
            // La version statique reste visible tant que la base n'est pas prête.
            error_log('Lecture du CV impossible : ' . $exception->getMessage());
        }

        return $cv;
    }
}
