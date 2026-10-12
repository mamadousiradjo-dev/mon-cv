<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\Api;
use App\Infrastructure\AuthSession;
use PDO;

final class PhotoController
{
    private const MAX_BYTES = 5 * 1024 * 1024;

    public function __construct(private readonly PDO $database, private readonly AuthController $auth) {}

    public function upload(): never
    {
        $this->auth->requireOwner();
        AuthSession::verify();
        $file = $_FILES['photo'] ?? null;
        if (!is_array($file) || $file['error'] !== UPLOAD_ERR_OK || $file['size'] > self::MAX_BYTES || $file['size'] < 1 || !is_uploaded_file($file['tmp_name'])) {
            Api::json(['error' => 'Choisissez une image JPG, PNG ou WebP de 5 Mo maximum.'], 422);
        }
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if (!isset($extensions[$mime]) || getimagesize($file['tmp_name']) === false) {
            Api::json(['error' => 'Format d’image invalide.'], 422);
        }
        $directory = dirname(__DIR__, 2) . '/storage/uploads';
        if (!is_dir($directory) && !mkdir($directory, 0750, true)) Api::json(['error' => 'Stockage indisponible.'], 500);
        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        $destination = $directory . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) Api::json(['error' => 'Envoi impossible.'], 500);
        try {
            $query = $this->database->prepare('UPDATE user_profile SET profile_photo_path = ? WHERE id = 1');
            $query->execute(['uploads/' . $filename]);
            if ($query->rowCount() === 0) throw new \RuntimeException('Profil absent. Lancez setup.php.');
        } catch (\Throwable $exception) {
            unlink($destination);
            throw $exception;
        }
        Api::json(['photo' => 'uploads/' . $filename]);
    }

    public static function show(string $filename): never
    {
        $path = dirname(__DIR__, 2) . '/storage/uploads/' . $filename;
        if (!is_file($path)) Api::json(['error' => 'Image introuvable.'], 404);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        header('Content-Type: ' . ['jpg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'][$extension]);
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: public, max-age=3600');
        readfile($path);
        exit;
    }
}
