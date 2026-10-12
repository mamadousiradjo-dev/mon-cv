<?php
declare(strict_types=1);

namespace App\Controller;

use App\Infrastructure\AuthSession;
use App\Infrastructure\Response;
use App\Infrastructure\View;
use App\Model\CvModel;
use App\Model\UserModel;

final class PageController
{
    public function __construct(
        private readonly CvModel $cv,
        private readonly ?UserModel $users,
    ) {}

    private function currentUser(): ?array
    {
        $id = AuthSession::userId();
        if ($id === null || $this->users === null) {
            return null;
        }
        $user = $this->users->byId($id);
        if ($user === false) {
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
        $this->show('home', ['cv' => $this->cv->getCv()]);
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
        if ($user === null || $user['role'] !== 'admin') {
            Response::error(403, 'Accès réservé au propriétaire.');
        }
        $this->show('pages/utilisateurs', ['users' => $this->users->all()]);
    }
}
