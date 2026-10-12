<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\CvModel;
use PDO;
use PDOException;

// Le repository lit et écrit le CV dans MySQL ; le modèle ne connaît pas SQL.
final class CvRepository
{
    public function __construct(private readonly ?PDO $database) {}

    public function find(): CvModel
    {
        $default = CvModel::defaults();
        if ($this->database === null) {
            return $default;
        }

        $photo = $default->photo;
        $formation = $default->formation;
        $experience = $default->experience;

        try {
            $savedPhoto = $this->database->query('SELECT profile_photo_path FROM user_profile WHERE id = 1 LIMIT 1')->fetchColumn();
            // Ancien chemin du portrait conservé lors de la fusion des dossiers d'upload.
            if ($savedPhoto === 'images/upload/profile_1791654074.jpeg') {
                $savedPhoto = 'images/profile_1791654074.jpeg';
            }
            if (is_string($savedPhoto) && self::isAllowedPhotoPath($savedPhoto)) {
                $photo = $savedPhoto;
            }

            $savedFormation = $this->database->query('SELECT diplome, etablissement, annee FROM formations ORDER BY id LIMIT 1')->fetch();
            if ($savedFormation !== false) {
                $formation = $savedFormation;
            }

            $savedExperience = $this->database->query('SELECT titre, entreprise, periode, description FROM experiences ORDER BY id LIMIT 1')->fetch();
            if ($savedExperience !== false) {
                $experience = $savedExperience;
            }
        } catch (PDOException $exception) {
            // Le CV de secours reste visible tant que la base n'est pas prête.
            error_log('Lecture du CV impossible : ' . $exception->getMessage());
        }

        return new CvModel($photo, $formation, $experience);
    }

    public function updatePhoto(string $path): ?bool
    {
        if ($this->database === null) {
            return null;
        }
        if (!self::isAllowedPhotoPath($path) || !str_starts_with($path, 'uploads/')) {
            throw new \InvalidArgumentException('Chemin de photo invalide.');
        }
        $query = $this->database->prepare('UPDATE user_profile SET profile_photo_path = ? WHERE id = 1');
        $query->execute([$path]);
        return $query->rowCount() === 1;
    }

    private static function isAllowedPhotoPath(string $path): bool
    {
        return (str_starts_with($path, 'images/') && !str_contains($path, '..')) ||
            preg_match('~^uploads/[a-f0-9]{32}\.(?:jpg|png|webp)$~', $path) === 1;
    }
}
