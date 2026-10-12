<?php
$currentPage = basename($_SERVER['SCRIPT_NAME'] ?? 'index.php');
$links = [
    '/' => ['Accueil', 'index.php', 'fa-house'],
    '/pages/projets.php' => ['Projets', 'projets.php', 'fa-diagram-project'],
    '/pages/contact.php' => ['Contact', 'contact.php', 'fa-envelope'],
];
?>
<nav aria-label="Navigation principale" class="bg-navy-900 text-white rounded-xl shadow-lg p-4 flex flex-wrap justify-center items-center gap-4 sm:gap-8 text-sm font-medium tracking-wide">
    <?php foreach ($links as $url => [$label, $file, $icon]): ?>
        <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>"
           <?= $currentPage === $file ? 'aria-current="page"' : '' ?>
           class="hover:text-sky-300 transition flex items-center space-x-2">
            <i class="fa-solid <?= htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"></i>
            <span><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
        </a>
    <?php endforeach; ?>
    <a id="nav-register" href="/pages/inscription.php" class="hover:text-sky-300">Inscription</a>
    <a id="nav-login" href="/pages/connexion.php" class="hover:text-sky-300">Connexion</a>
    <a id="nav-users" href="/pages/utilisateurs.php" class="hidden hover:text-sky-300">Utilisateurs</a>
    <span id="nav-user" class="hidden text-sky-300"></span>
    <button id="nav-logout" type="button" class="hidden hover:text-sky-300">Déconnexion</button>
</nav>
