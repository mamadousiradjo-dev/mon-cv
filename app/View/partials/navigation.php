<?php
use App\Infrastructure\View;

$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$links = [
    '/' => ['Accueil', 'fa-house'],
    '/projets' => ['Projets', 'fa-diagram-project'],
    '/contact' => ['Contact', 'fa-envelope'],
];
?>
<nav aria-label="Navigation principale" class="bg-navy-900 text-white rounded-xl shadow-lg p-4 flex flex-wrap justify-center items-center gap-4 sm:gap-8 text-sm font-medium tracking-wide">
    <?php foreach ($links as $path => [$label, $icon]): ?>
        <a href="<?= View::e($path) ?>"
           <?= $currentPath === $path ? 'aria-current="page"' : '' ?>
           class="hover:text-sky-300 transition flex items-center space-x-2">
            <i class="fa-solid <?= View::e($icon) ?>" aria-hidden="true"></i>
            <span><?= View::e($label) ?></span>
        </a>
    <?php endforeach; ?>

    <?php if ($user === null): ?>
        <a href="/inscription" class="hover:text-sky-300">Inscription</a>
        <a href="/connexion" class="hover:text-sky-300">Connexion</a>
    <?php else: ?>
        <?php if ($user['role'] === 'admin'): ?>
            <a href="/utilisateurs" class="hover:text-sky-300">Utilisateurs</a>
        <?php endif; ?>
        <span class="text-sky-300"><?= View::e($user['nom']) ?></span>
        <form action="/deconnexion" method="post">
            <input type="hidden" name="csrf" value="<?= View::e($csrf) ?>">
            <button type="submit" class="hover:text-sky-300">Déconnexion</button>
        </form>
    <?php endif; ?>
</nav>
