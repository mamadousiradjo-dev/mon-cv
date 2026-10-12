<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\CvRepository;
use InvalidArgumentException;

final class PhotoController
{
    public function __construct(
        private readonly CvRepository $cv,
        private readonly AuthController $auth,
    ) {}

    public function upload(): never
    {
        $this->auth->requireOwner();
        AuthSession::verify();
        try {
            $this->cv->savePhoto($_FILES['photo'] ?? null);
            AuthSession::flash('Photo enregistrée.');
        } catch (InvalidArgumentException $exception) {
            AuthSession::flash($exception->getMessage());
        }
        Response::redirect('/');
    }
}
