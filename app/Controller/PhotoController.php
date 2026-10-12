<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\AuthSession;
use App\Infrastructure\Response;
use PDO;

final class PhotoController
{
    private const MAX_BYTES = 5 * 1024 * 1024;

    public function __construct(
        private readonly ?PDO $database,
        private readonly AuthController $auth,
    ) {}

    public function upload(): never
    {
        $this->auth->requireOwner();
        AuthSession::verify();
        if ($this->database === null) {
            Response::error(503, 'Base de données indisponible.');
        }

        $file = $_FILES['photo'] ?? null;
        if (!is_array($file) || $file['error'] !== UPLOAD_ERR_OK ||
            $file['size'] < 1 || $file['size'] > self::MAX_BYTES ||
            !is_uploaded_file($file['tmp_name'])) {
            $this->reject('Choisissez une image JPG, PNG ou WebP de 5 Mo maximum.');
        }

        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
        if (!isset($extensions[$mime]) || getimagesize($file['tmp_name']) === false) {
            $this->reject('Format d’image invalide.');
        }

        $directory = dirname(__DIR__, 2) . '/storage/uploads';
        if (!is_dir($directory) && !mkdir($directory, 0750, true)) {
            Response::error(500, 'Stockage indisponible.');
        }
        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        $destination = $directory . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            Response::error(500, 'Envoi impossible.');
        }

        try {
            $query = $this->database->prepare('UPDATE user_profile SET profile_photo_path = ? WHERE id = 1');
            $query->execute(['uploads/' . $filename]);
            if ($query->rowCount() === 0) {
                throw new \RuntimeException('Profil absent. Lancez setup.php.');
            }
        } catch (\Throwable $exception) {
            unlink($destination);
            throw $exception;
        }
        AuthSession::flash('Photo enregistrée.');
        Response::redirect('/');
    }

    public static function show(string $filename): never
    {
        $path = dirname(__DIR__, 2) . '/storage/uploads/' . $filename;
        if (!is_file($path)) {
            Response::error(404, 'Image introuvable.');
        }
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        header('Content-Type: ' . ['jpg' => 'image/jpeg', 'png' => 'image/png', 'webp' => 'image/webp'][$extension]);
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: public, max-age=3600');
        readfile($path);
        exit;
    }

    private function reject(string $message): never
    {
        AuthSession::flash($message);
        Response::redirect('/');
    }
}
