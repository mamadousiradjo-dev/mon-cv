<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\CvRepository;

final class PhotoController
{
    private const MAX_BYTES = 5 * 1024 * 1024;

    public function __construct(
        private readonly CvRepository $cv,
        private readonly AuthController $auth,
    ) {}

    public function upload(): never
    {
        $this->auth->requireOwner();
        AuthSession::verify();
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

        $directory = dirname(__DIR__, 2) . '/public/uploads';
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
            Response::error(500, 'Stockage indisponible.');
        }
        $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
        $destination = $directory . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            Response::error(500, 'Envoi impossible.');
        }

        if (!chmod($destination, 0644)) {
            unlink($destination);
            Response::error(500, 'Envoi impossible.');
        }

        try {
            $saved = $this->cv->updatePhoto('uploads/' . $filename);
            if ($saved === null) {
                unlink($destination);
                Response::error(503, 'Base de données indisponible.');
            }
            if (!$saved) {
                throw new \RuntimeException('Profil absent. Lancez setup.php.');
            }
        } catch (\Throwable $exception) {
            unlink($destination);
            throw $exception;
        }
        AuthSession::flash('Photo enregistrée.');
        Response::redirect('/');
    }

    private function reject(string $message): never
    {
        AuthSession::flash($message);
        Response::redirect('/');
    }
}
