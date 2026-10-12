<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\UserModel;
use App\Repository\CvRepository;
use App\Repository\UserRepository;
use App\View\View;

final class PageController
{
    public function __construct(
        private readonly CvRepository $cv,
        private readonly ?UserRepository $users,
    ) {}

    private function currentUser(): ?UserModel
    {
        $id = AuthSession::userId();
        if ($id === null || $this->users === null) {
            return null;
        }
        $user = $this->users->byId($id);
        if ($user === null) {
            AuthSession::logout();
            return null;
        }
        return $user;
    }

    private function show(string $view, array $data = []): void
    {
        View::render($view, array_merge($data, [
            'user' => $this->currentUser(),
            'csrf' => AuthSession::token(),
            'flash' => AuthSession::takeFlash(),
        ]));
    }

    public function home(): void
    {
        $this->show('home', ['cv' => $this->cv->find()]);
    }

    public function projects(): void
    {
        $this->show('pages/projets');
    }

    public function contact(): void
    {
        $this->show('pages/contact');
    }

    public function register(): void
    {
        $this->show('pages/inscription');
    }

    public function login(): void
    {
        $this->show('pages/connexion');
    }

    public function users(): void
    {
        $user = $this->currentUser();
        if ($user === null || !$user->isOwner()) {
            Response::error(403, 'Accès réservé au propriétaire.');
        }
        $this->show('pages/utilisateurs', ['users' => $this->users->all()]);
    }
}
