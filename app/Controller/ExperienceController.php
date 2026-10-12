<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\ExperienceRepository;
use App\View\View;

final class ExperienceController
{
    public function __construct(
        private readonly AuthController $auth,
        private readonly ?ExperienceRepository $experiences,
    ) {}

    public function form(): void
    {
        $user = $this->auth->requireOwner();
        View::render('pages/ajouter-experience', [
            'user' => $user,
            'csrf' => AuthSession::token(),
            'flash' => AuthSession::takeFlash(),
        ]);
    }

    public function create(): never
    {
        $this->auth->requireOwner();
        AuthSession::verify();
        if ($this->experiences === null) {
            Response::error(503, 'Base de données indisponible.');
        }

        // TODO élève : lire les quatre champs POST, créer et valider ExperienceModel,
        // appeler ExperienceRepository::create(), puis rediriger vers /.
        // En cas de saisie invalide, afficher un message et revenir au formulaire.
        Response::error(501, 'Exercice à compléter : enregistrement d’une expérience.');
    }
}
