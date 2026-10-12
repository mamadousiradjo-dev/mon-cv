<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\CvModel;
use PDO;
use PDOException;

final class CvRepository
{
    public function __construct(private readonly ?PDO $database) {}

    public function find(): CvModel
    {
        $default = self::fallback();
        if ($this->database === null) {
            return $default;
        }

        $photo = $default->photo;
        $formation = $default->formation;
        $experience = $default->experience;
        try {
            $savedPhoto = $this->database->query('SELECT profile_photo_path FROM user_profile WHERE id = 1 LIMIT 1')->fetchColumn();
            if ($savedPhoto === 'images/upload/profile_1791654074.jpeg') {
                $savedPhoto = 'images/profile_1791654074.jpeg';
            }
            if (is_string($savedPhoto) && self::validPhotoPath($savedPhoto)) {
                $photo = $savedPhoto;
            }
            $savedFormation = $this->database->query('SELECT diplome, etablissement, annee FROM formations ORDER BY id LIMIT 1')->fetch();
            $savedExperience = $this->database->query('SELECT titre, entreprise, periode, description FROM experiences ORDER BY id LIMIT 1')->fetch();
            $formation = $savedFormation ?: $formation;
            $experience = $savedExperience ?: $experience;
        } catch (PDOException $exception) {
            error_log('Lecture du CV impossible : ' . $exception->getMessage());
        }
        return new CvModel($photo, $formation, $experience);
    }

    public function savePhoto(?array $file): void
    {
        if ($this->database === null) {
            throw new \RuntimeException('Base de données indisponible.');
        }
        $tmp = $file['tmp_name'] ?? null;
        $size = $file['size'] ?? null;
        if (($file['error'] ?? null) !== UPLOAD_ERR_OK || !is_string($tmp) ||
            !is_int($size) || $size < 1 || $size > 5 * 1024 * 1024 || !is_uploaded_file($tmp)) {
            throw new \InvalidArgumentException('Choisissez une image JPG, PNG ou WebP de 5 Mo maximum.');
        }
        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($tmp);
        if (!isset($extensions[$mime]) || getimagesize($tmp) === false) {
            throw new \InvalidArgumentException('Format d’image invalide.');
        }

        $directory = dirname(__DIR__, 2) . '/public/uploads';
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
            throw new \RuntimeException('Stockage indisponible.');
        }
        $name = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        $destination = $directory . '/' . $name;
        if (!move_uploaded_file($tmp, $destination)) {
            throw new \RuntimeException('Envoi impossible.');
        }
        try {
            if (!chmod($destination, 0644)) {
                throw new \RuntimeException('Envoi impossible.');
            }
            $query = $this->database->prepare('UPDATE user_profile SET profile_photo_path = ? WHERE id = 1');
            $query->execute(['uploads/' . $name]);
            if ($query->rowCount() !== 1) {
                throw new \RuntimeException('Profil absent. Lancez setup.php.');
            }
        } catch (\Throwable $exception) {
            unlink($destination);
            throw $exception;
        }
    }

    private static function validPhotoPath(string $path): bool
    {
        return (str_starts_with($path, 'images/') && !str_contains($path, '..')) ||
            preg_match('~^uploads/[a-f0-9]{32}\.(?:jpg|png|webp)$~', $path) === 1;
    }

    private static function fallback(): CvModel
    {
        return new CvModel(
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
